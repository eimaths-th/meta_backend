<?php

namespace Tests\Feature;

use App\Models\FormManage;
use App\Models\FormPakages;
use App\Models\ReceiptForm;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReceiptPackageSelectionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        $this->actingAs(User::create([
            'name' => 'Receipt package test user',
            'email' => 'receipt-package-test-'.uniqid().'@example.com',
            'password' => bcrypt('test-password'),
            'level' => 1,
        ]));
    }

    public function test_generate_modal_lists_packages_for_the_registration_form(): void
    {
        $form = $this->createForm('modal-options');
        $selectedPackage = $this->createPackage($form, 'Original package', '990');
        $otherPackage = $this->createPackage($form, 'Upgrade package', '1990');

        $otherForm = $this->createForm('other-modal-options');
        $this->createPackage($otherForm, 'Package from another form', '9999');

        $registration = $this->createRegistration($form, $selectedPackage);

        $this->getJson(route('receipts_form.edit', $registration->id))
            ->assertOk()
            ->assertJsonPath('selected_package_ids.0', $selectedPackage->id)
            ->assertJsonCount(2, 'packages')
            ->assertJsonFragment([
                'id' => $otherPackage->id,
                'package' => 'Upgrade package',
                'price' => '1990',
            ])
            ->assertJsonMissing([
                'package' => 'Package from another form',
            ]);
    }

    public function test_generating_receipt_uses_the_selected_package_name_and_price(): void
    {
        $form = $this->createForm('generate-selection');
        $originalPackage = $this->createPackage($form, 'Original package', '990');
        $selectedPackage = $this->createPackage($form, 'Upgrade package', '1990');
        $registration = $this->createRegistration($form, $originalPackage);

        $this->postJson(route('receipts_form.store'), [
            'fid' => $registration->id,
            'sfield' => $form->sfield,
            'submission_date' => '2026-08-18',
            'first_name' => 'Package',
            'last_name' => 'Customer',
            'street_address' => '123 Test Road',
            'postcode' => '10110',
            'name_parent' => 'Parent Customer',
            'mobile' => '0812345678',
            'grade' => 'Grade 3',
            'package_id' => $selectedPackage->id,
            // These values are intentionally tampered with. The server must use
            // the selected configured package as the canonical source instead.
            'package' => 'Tampered package',
            'description' => 'Tampered description',
        ])
            ->assertOk()
            ->assertJsonPath('success', 'Receive Add successfully');

        $registration->refresh();

        $this->assertSame((string) $selectedPackage->id, (string) $registration->package_id);
        $this->assertSame('Upgrade package', $registration->package);
        $this->assertDatabaseHas('receipts', [
            'id' => $registration->rec_id,
            'package' => 'Upgrade package',
            'description' => 'Upgrade package',
        ]);
        $this->assertDatabaseHas('receipt_details', [
            'receipt_id' => $registration->rec_id,
            'description' => 'Upgrade package',
            'quantity' => 1,
            'unitprice' => 1990,
        ]);
    }

    public function test_generate_rejects_a_package_from_another_form(): void
    {
        $form = $this->createForm('reject-selection');
        $originalPackage = $this->createPackage($form, 'Original package', '990');
        $registration = $this->createRegistration($form, $originalPackage);

        $otherForm = $this->createForm('reject-other-selection');
        $otherPackage = $this->createPackage($otherForm, 'Wrong package', '9999');

        $this->postJson(route('receipts_form.store'), [
            'fid' => $registration->id,
            'sfield' => $form->sfield,
            'submission_date' => '2026-08-18',
            'first_name' => 'Package',
            'last_name' => 'Customer',
            'street_address' => '123 Test Road',
            'postcode' => '10110',
            'name_parent' => 'Parent Customer',
            'mobile' => '0812345678',
            'grade' => 'Grade 3',
            'package_id' => $otherPackage->id,
            'package' => 'Wrong package',
            'description' => 'Wrong package',
        ])
            ->assertOk()
            ->assertJsonFragment([
                'The selected package does not belong to this registration form.',
            ]);

        $registration->refresh();
        $this->assertSame((string) $originalPackage->id, (string) $registration->package_id);
        $this->assertSame(0, (int) $registration->generate);
    }

    public function test_legacy_registration_without_configured_packages_can_still_generate(): void
    {
        $form = $this->createForm('legacy-selection');
        $registration = ReceiptForm::create([
            'sfield' => $form->sfield,
            'submission_date' => '2026-08-18',
            'first_name' => 'Legacy',
            'last_name' => 'Customer',
            'street_address' => '123 Test Road',
            'postcode' => '10110',
            'name_parent' => 'Parent Customer',
            'mobile' => '0812345678',
            'grade' => 'Grade 3',
            'package_id' => null,
            'package' => 'Legacy package : 750 Baht',
            'generate' => 0,
        ]);

        $this->postJson(route('receipts_form.store'), [
            'fid' => $registration->id,
            'sfield' => $form->sfield,
            'submission_date' => '2026-08-18',
            'first_name' => 'Legacy',
            'last_name' => 'Customer',
            'street_address' => '123 Test Road',
            'postcode' => '10110',
            'name_parent' => 'Parent Customer',
            'mobile' => '0812345678',
            'grade' => 'Grade 3',
        ])
            ->assertOk()
            ->assertJsonPath('success', 'Receive Add successfully');

        $registration->refresh();
        $this->assertDatabaseHas('receipt_details', [
            'receipt_id' => $registration->rec_id,
            'description' => 'Legacy package : 750 Baht',
            'unitprice' => 750,
        ]);
    }

    private function createForm(string $suffix): FormManage
    {
        $form = FormManage::create([
            'form_name' => 'Receipt Package Test '.$suffix,
            'form_route' => 'receipt-package-test-'.$suffix,
            'slug' => 'receipt-package-test-'.$suffix.'-'.uniqid(),
            'package_multiselect' => false,
        ]);
        $form->sfield = (string) $form->id;
        $form->save();

        return $form;
    }

    private function createPackage(
        FormManage $form,
        string $name,
        string $price,
    ): FormPakages {
        return FormPakages::create([
            'form_id' => $form->id,
            'sfield' => $form->sfield,
            'form_name' => $form->form_name,
            'form_route' => $form->form_route,
            'package' => $name,
            'price' => $price,
            'has_exam_mode' => false,
        ]);
    }

    private function createRegistration(
        FormManage $form,
        FormPakages $package,
    ): ReceiptForm {
        return ReceiptForm::create([
            'sfield' => $form->sfield,
            'submission_date' => '2026-08-18',
            'first_name' => 'Package',
            'last_name' => 'Customer',
            'street_address' => '123 Test Road',
            'postcode' => '10110',
            'name_parent' => 'Parent Customer',
            'mobile' => '0812345678',
            'grade' => 'Grade 3',
            'package_id' => $package->id,
            'package' => $package->package,
            'generate' => 0,
        ]);
    }
}
