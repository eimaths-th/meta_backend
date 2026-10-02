<?php

namespace Tests\Feature;

use App\Models\FormManage;
use App\Models\FormPakages;
use App\Models\User;
use App\Support\FormBannerSettings;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class FormBannerSettingsTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->actingAs(User::create([
            'name' => 'Banner settings test',
            'email' => 'banner-test-' . uniqid() . '@example.com',
            'password' => bcrypt('test-password'),
            'level' => 1,
        ]));
    }

    public function test_saved_banner_settings_reopen_in_manager_and_apply_to_registration(): void
    {
        $form = $this->createForm();
        $settings = ['fit' => 'cover', 'desktop_height' => 300, 'mobile_height' => 180, 'position_x' => 35, 'position_y' => 70];

        $this->postJson(route('form-manage.store'), $this->payload($form) + ['banner_settings' => $settings])
            ->assertOk()->assertJsonPath('status', 'success');

        $form->refresh();
        $this->assertSame($settings, $form->banner_display);
        $this->get(route('create-form', ['id' => $form->id]))
            ->assertOk()
            ->assertSee('name="banner_settings[desktop_height]"', false)
            ->assertSee('value="300"', false)
            ->assertSee('object-fit: cover; object-position: 35% 70%', false);

        $html = $this->registrationHtml($form);
        $this->assertStringContainsString('--banner-desktop-height: 300px; --banner-mobile-height: 180px; --banner-fit: cover; --banner-position: 35% 70%', $html);
    }

    public function test_older_editor_payload_preserves_saved_banner_settings(): void
    {
        $form = $this->createForm();
        $settings = ['fit' => 'cover', 'desktop_height' => 360, 'mobile_height' => 200, 'position_x' => 0, 'position_y' => 100];
        $form->update(['banner_settings' => $settings]);

        $this->postJson(route('form-manage.store'), $this->payload($form))
            ->assertOk()->assertJsonPath('status', 'success');
        $this->assertSame($settings, $form->fresh()->banner_display);
    }

    public function test_invalid_banner_values_do_not_overwrite_the_form(): void
    {
        $form = $this->createForm();
        $invalid = ['fit' => 'stretch', 'desktop_height' => 9000, 'mobile_height' => 20, 'position_x' => -1, 'position_y' => 101];

        $this->postJson(route('form-manage.store'), $this->payload($form) + ['banner_settings' => $invalid])
            ->assertJsonPath('status', 'error')
            ->assertJsonStructure(['errors' => ['banner_settings.fit', 'banner_settings.desktop_height', 'banner_settings.mobile_height', 'banner_settings.position_x', 'banner_settings.position_y']]);

        $this->assertNull($form->fresh()->banner_settings);
        $this->assertSame(FormBannerSettings::DEFAULTS, $form->fresh()->banner_display);
    }

    public function test_automatic_mode_replaces_cropping_without_discarding_saved_manual_settings(): void
    {
        $form = $this->createForm();
        $manual = ['fit' => 'cover', 'desktop_height' => 479, 'mobile_height' => 317, 'position_x' => 21, 'position_y' => 44];
        $form->update(['banner_settings' => $manual]);

        $this->postJson(route('form-manage.store'), $this->payload($form) + ['banner_settings' => ['fit' => 'auto']])
            ->assertOk()->assertJsonPath('status', 'success');
        $this->assertSame(array_replace($manual, ['fit' => 'auto']), $form->fresh()->banner_display);

        $manager = $this->get(route('create-form', ['id' => $form->id]))->assertOk()->getContent();
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="UTF-8">' . $manager);
        $xpath = new \DOMXPath($document);
        $this->assertSame(1, $xpath->query('//details[@id="banner-advanced" and not(@open)]')->length);
        $this->assertSame(1, $xpath->query('//fieldset[@id="banner-manual-controls" and @disabled and @hidden]')->length);
        $this->assertSame(2, $xpath->query('//figure[@data-preview]//img')->length);
        $this->assertSame(1, $xpath->query('//select[@id="banner-fit"]/option[@value="auto" and @selected]')->length);
        $this->assertStringContainsString('/form/' . $form->slug, $manager);
        $this->assertSame(0, $xpath->query('//footer[contains(@class,"meta-footer")]')->length);
        $this->assertStringContainsString('name="footer_company_name"', $manager);
        $this->assertStringContainsString('Submit Application', $manager);
        $this->assertStringContainsString('Clear Form', $manager);

        $html = $this->registrationHtml($form->fresh());
        $this->assertStringContainsString('class="registration-banner registration-banner-auto"', $html);
        $this->assertStringContainsString('<footer', $html);
        $this->assertStringContainsString('--banner-auto-desktop-max: 360px; --banner-auto-mobile-max: 240px', $html);
    }

    public function test_public_page_shows_package_price_and_all_social_channels_without_unsafe_links(): void
    {
        $form = $this->createForm();
        $form->footer_facebook = 'https://example.com/facebook';
        $form->footer_line = 'javascript:alert(1)';
        $form->footer_instagram = null;
        $form->footer_youtube = '  https://example.com/youtube  ';
        $form->setRelation('packages', collect([new FormPakages(['package' => 'ค่าสมัครตัวอย่าง', 'price' => '1500'])]));
        $html = $this->registrationHtml($form);

        $this->assertStringContainsString('1,500 <small>บาท</small>', $html);
        $this->assertStringContainsString('href="https://example.com/facebook"', $html);
        $this->assertStringContainsString('href="https://example.com/youtube"', $html);
        $this->assertStringContainsString('LINE ยังไม่เปิดใช้งาน', $html);
        $this->assertStringContainsString('Instagram ยังไม่เปิดใช้งาน', $html);
        $this->assertStringNotContainsString('href="javascript:', $html);
        $this->assertStringContainsString('--banner-desktop-height: 240px; --banner-mobile-height: 160px; --banner-fit: contain', $html);
        $this->assertStringContainsString('class="registration-banner registration-banner-auto"', $html);
    }

    /** @dataProvider rejectedBannerFiles */
    public function test_invalid_banner_upload_leaves_the_saved_image_and_settings_unchanged(string $kind): void
    {
        $form = $this->createForm();
        $file = match ($kind) {
            'oversized' => UploadedFile::fake()->image('large.png', 10, 10)->size(5121),
            'svg' => UploadedFile::fake()->create('vector.svg', 1, 'image/svg+xml'),
            default => UploadedFile::fake()->create('text.txt', 1, 'text/plain'),
        };
        $before = $form->getAttributes();
        $this->postJson(route('form-manage.store'), $this->payload($form) + ['brand' => $file])
            ->assertJsonPath('status', 'error')->assertJsonStructure(['errors' => ['brand']]);
        $this->assertSame($before, $form->fresh()->getAttributes());
    }

    public static function rejectedBannerFiles(): array
    {
        return ['over 5 MB' => ['oversized'], 'unsupported SVG' => ['svg'], 'text file' => ['text']];
    }

    private function createForm(): FormManage
    {
        $form = FormManage::create([
            'form_name' => 'Banner test',
            'form_route' => 'banner-test-' . uniqid(),
            'slug' => 'banner-test-' . uniqid(),
            'brand' => 'test-banner.jpg',
            'image_payment' => 'test-payment.jpg',
            'registration_fee_label' => 'ค่าสมัคร',
            'show_footer' => true,
        ]);
        $form->sfield = (string) $form->id;
        $form->save();

        return $form->refresh();
    }

    private function payload(FormManage $form): array
    {
        $fields = array_fill_keys(array_keys(config('form_fields')), ['enabled' => false, 'required' => false]);
        $footer = array_filter($form->getAttributes(), fn ($key) => str_starts_with($key, 'footer_'), ARRAY_FILTER_USE_KEY);

        return array_merge($footer, [
            'form_id' => $form->id, 'form_name' => $form->form_name,
            'form_route' => $form->form_route, 'sfield' => $form->sfield,
            'title' => 'Title', 'sub_title' => 'Subtitle', 'head_title' => 'Heading',
            'registration_date_label' => 'รับสมัคร', 'contest_date_label' => 'วันสอบ',
            'registration_fee_label' => 'ค่าสมัคร', 'contest_date' => '10/25/2026 - 10/25/2026',
            'text_footer' => 'Footer', 'text_warning' => 'Warning', 'text_policy' => 'Policy',
            'field_settings' => $fields, 'contact_email_detail' => 'Email instructions',
            'oldBrand' => $form->brand, 'oldImagePayment' => $form->image_payment,
            'show_footer' => true,
        ]);
    }

    private function registrationHtml(FormManage $form): string
    {
        if (!$form->relationLoaded('packages')) {
            $form->setRelation('packages', collect());
        }
        $form->setRelation('grades', collect());

        return view('forms_manage.view', [
            'form' => $form, 'date' => '1–30 October 2026', 'errors' => new ViewErrorBag,
        ])->render();
    }
}
