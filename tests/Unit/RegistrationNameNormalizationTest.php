<?php

namespace Tests\Unit;

use App\Http\Controllers\ReceiptFormController;
use Illuminate\Http\Request;
use ReflectionMethod;
use Tests\TestCase;

class RegistrationNameNormalizationTest extends TestCase
{
    /** @dataProvider mobileNameProvider */
    public function test_it_removes_invisible_mobile_characters_and_normalizes_spaces(
        string $input,
        string $expected,
    ): void {
        $method = new ReflectionMethod(ReceiptFormController::class, 'normalizeEnglishNameInput');
        $method->setAccessible(true);

        $this->assertSame(
            $expected,
            $method->invoke(new ReceiptFormController, $input),
        );
    }

    public function mobileNameProvider(): array
    {
        return [
            'LINE zero-width characters' => [
                "\u{FEFF}\u{200B}Oldest\u{200D}",
                'Oldest',
            ],
            'non-breaking and repeated spaces' => [
                "  Mary\u{00A0}\u{00A0}Jane  ",
                'Mary Jane',
            ],
            'mobile newline and tab' => [
                "John\n\tSmith",
                'John Smith',
            ],
        ];
    }

    public function test_it_does_not_strip_non_english_letters_that_validation_must_reject(): void
    {
        $method = new ReflectionMethod(ReceiptFormController::class, 'normalizeEnglishNameInput');
        $method->setAccessible(true);

        $thaiName = "\u{0E2A}\u{0E21}\u{0E0A}\u{0E32}\u{0E22}";

        $this->assertSame(
            $thaiName,
            $method->invoke(new ReceiptFormController, $thaiName),
        );
    }

    public function test_it_normalizes_contact_fields_before_validation(): void
    {
        $method = new ReflectionMethod(ReceiptFormController::class, 'normalizeRegistrationContactFields');
        $method->setAccessible(true);
        $request = Request::create('/', 'POST', [
            'email' => '  Student@Example.COM  ',
            'phone' => '  (081) 234-5678  ',
            'postcode' => '  10110  ',
        ]);

        $method->invoke(new ReceiptFormController, $request);

        $this->assertSame('Student@Example.COM', $request->input('email'));
        $this->assertSame('(081) 234-5678', $request->input('phone'));
        $this->assertSame('10110', $request->input('postcode'));
    }

    /** @dataProvider booleanSettingProvider */
    public function test_it_interprets_form_setting_booleans_consistently($value, bool $default, bool $expected): void
    {
        $method = new ReflectionMethod(ReceiptFormController::class, 'normalizeFormFieldBoolean');
        $method->setAccessible(true);

        $this->assertSame(
            $expected,
            $method->invoke(new ReceiptFormController, $value, $default),
        );
    }

    public function booleanSettingProvider(): array
    {
        return [
            'string false' => ['false', true, false],
            'string zero' => ['0', true, false],
            'string true' => ['true', false, true],
            'missing setting uses default' => [null, true, true],
        ];
    }
}
