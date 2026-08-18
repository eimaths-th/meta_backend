<?php

namespace Tests\Feature;

use App\Models\FormGrades;
use App\Models\FormManage;
use App\Models\FormPakages;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FormManageOptionUpdateTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        $user = User::create([
            'name' => 'Form option test user',
            'email' => 'form-option-test-' . uniqid() . '@example.com',
            'password' => bcrypt('test-password'),
            'level' => 1,
        ]);

        $this->actingAs($user);
    }

    public function test_package_edit_updates_the_package_for_the_selected_form(): void
    {
        $form = $this->createForm('package-edit');
        $package = $this->createPackage($form, 'Old package', '100');

        $response = $this->postJson(route('edit-option-package'), [
            'id' => $package->id,
            'form_id' => $form->id,
            'value' => 'Updated package',
            'price' => 250,
            'has_exam_mode' => true,
            'online_limit' => 20,
            'onsite_limit' => 30,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.package', 'Updated package');

        $this->assertDatabaseHas('forms_pakages', [
            'id' => $package->id,
            'form_id' => $form->id,
            'package' => 'Updated package',
            'price' => '250',
            'has_exam_mode' => 1,
            'online_limit' => 20,
            'onsite_limit' => 30,
        ]);
    }

    public function test_option_edits_cannot_silently_update_another_form(): void
    {
        $ownerForm = $this->createForm('owner-form');
        $otherForm = $this->createForm('other-form');
        $package = $this->createPackage($ownerForm, 'Protected package', '100');

        $this->postJson(route('edit-option-package'), [
            'id' => $package->id,
            'form_id' => $otherForm->id,
            'value' => 'Wrong update',
            'price' => 999,
            'has_exam_mode' => false,
        ])->assertNotFound();

        $this->assertDatabaseHas('forms_pakages', [
            'id' => $package->id,
            'package' => 'Protected package',
            'price' => '100',
        ]);
    }

    public function test_grade_edit_updates_the_grade_for_the_selected_form(): void
    {
        $form = $this->createForm('grade-edit');
        $grade = FormGrades::create([
            'form_id' => $form->id,
            'sfield' => $form->sfield,
            'form_name' => $form->form_name,
            'form_route' => $form->form_route,
            'grade' => 'Grade 1',
        ]);

        $this->postJson(route('edit-option-grade'), [
            'id' => $grade->id,
            'form_id' => $form->id,
            'value' => 'Grade 2',
        ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('forms_grades', [
            'id' => $grade->id,
            'form_id' => $form->id,
            'grade' => 'Grade 2',
        ]);
    }

    public function test_form_manage_page_renders_dynamic_options_with_special_characters(): void
    {
        $form = $this->createForm('special-characters');
        $this->createPackage($form, 'Tutor\'s "Plus" <2027>', '350');
        FormGrades::create([
            'form_id' => $form->id,
            'sfield' => $form->sfield,
            'form_name' => $form->form_name,
            'form_route' => $form->form_route,
            'grade' => 'Grade "A" <advanced>',
        ]);

        $this->get(route('create-form', ['id' => $form->id]))
            ->assertOk()
            ->assertSee('package-option', false)
            ->assertSee('grade-option', false);
    }

    public function test_existing_package_and_grade_are_deleted_from_the_database(): void
    {
        $form = $this->createForm('option-delete');
        $package = $this->createPackage($form, 'Delete package', '100');
        $grade = FormGrades::create([
            'form_id' => $form->id,
            'sfield' => $form->sfield,
            'form_name' => $form->form_name,
            'form_route' => $form->form_route,
            'grade' => 'Delete grade',
        ]);

        $this->postJson(route('delete-option-package'), [
            'id' => $package->id,
            'form_id' => $form->id,
            'index' => 1,
        ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->postJson(route('delete-option-grade'), [
            'id' => $grade->id,
            'form_id' => $form->id,
            'index' => 1,
        ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertDatabaseMissing('forms_pakages', ['id' => $package->id]);
        $this->assertDatabaseMissing('forms_grades', ['id' => $grade->id]);
    }

    private function createForm(string $suffix): FormManage
    {
        $form = FormManage::create([
            'form_name' => 'Option Test ' . $suffix,
            'form_route' => 'option-test-' . $suffix,
            'slug' => 'option-test-' . $suffix . '-' . uniqid(),
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
}
