<?php

namespace Tests\Feature;

use App\Models\FormGrades;
use App\Models\FormManage;
use App\Models\FormPakages;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class RegistrationFormViewTest extends TestCase
{
    public function test_registration_view_renders_cross_platform_controls_and_valid_exam_mode_data(): void
    {
        $form = new FormManage([
            'form_name' => 'Compatibility Test',
            'form_route' => 'compatibility-test',
            'slug' => 'compatibility-test',
            'field_settings' => [
                'contact_email' => ['enabled' => false, 'required' => false],
                'student_photo' => ['enabled' => true, 'required' => false],
                'student_slip_photo' => ['enabled' => true, 'required' => true],
            ],
            'enable_exam_mode' => true,
        ]);
        $form->id = 999;
        $form->sfield = '999';

        $onlinePackage = new FormPakages([
            'package' => 'Online package',
            'has_exam_mode' => true,
            'linked_grades' => null,
        ]);
        $onlinePackage->id = 1001;

        $standardPackage = new FormPakages([
            'package' => 'Standard package',
            'has_exam_mode' => false,
            'linked_grades' => null,
        ]);
        $standardPackage->id = 1002;

        $grade = new FormGrades(['grade' => 'Grade 6']);
        $grade->id = 2001;

        $form->setRelation('packages', collect([$onlinePackage, $standardPackage]));
        $form->setRelation('grades', collect([$grade]));

        $html = view('forms_manage.view', [
            'form' => $form,
            'date' => '01 August 2026 - 15 September 2026',
            'errors' => new ViewErrorBag,
        ])->render();

        $this->assertStringNotContainsString('onsubmit="return check_input();"', $html);
        $this->assertStringNotContainsString("new Date().getTime() + '_' + file.name", $html);
        $this->assertStringContainsString('registrationUploadName(file)', $html);
        $this->assertStringContainsString('type="tel"', $html);
        $this->assertStringContainsString('autocomplete="given-name"', $html);
        $this->assertStringNotContainsString('id="email"', $html);
        $this->assertStringContainsString('assets/plugins/jquery/dist/jquery.min.js', $html);
        $this->assertStringContainsString('assets/plugins/dropzone/dist/min/dropzone.min.js', $html);
        $this->assertMatchesRegularExpression(
            '/type="hidden"\s+id="drop1"[\s\S]*?data-upload-required="0"/',
            $html,
        );
        $this->assertMatchesRegularExpression(
            '/type="hidden"\s+id="drop2"[\s\S]*?data-upload-required="1"/',
            $html,
        );
        $this->assertMatchesRegularExpression('/1001\s*:\s*1\s*,\s*1002\s*:\s*0/', $html);
    }
}
