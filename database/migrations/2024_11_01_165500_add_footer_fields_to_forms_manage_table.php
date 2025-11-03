<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            // Footer visibility control
            $table->boolean('show_footer')->default(true)->after('text_policy');

            // Company Information
            $table->string('footer_company_name')->default('Meta Knowledge')->after('show_footer');
            $table->text('footer_description_1')->nullable()->after('footer_company_name')->default('ศูนย์รวมความรู้และการพัฒนาทักษะสำหรับนักเรียนและผู้ปกครอง');
            $table->text('footer_description_2')->nullable()->after('footer_description_1')->default('พัฒนาศักยภาพ สร้างอนาคตที่ดีกว่า');
            $table->string('footer_logo')->default('logo_meta.png')->after('footer_description_2');

            // About Us Section
            $table->string('footer_about_title')->default('เกี่ยวกับเรา')->after('footer_logo');
            $table->string('footer_feature_1')->nullable()->after('footer_about_title')->default('ระบบสอบและแข่งขันออนไลน์');
            $table->string('footer_feature_2')->nullable()->after('footer_feature_1')->default('หลักสูตรคุณภาพสำหรับทุกระดับชั้น');
            $table->string('footer_feature_3')->nullable()->after('footer_feature_2')->default('พัฒนาทักษะเพื่อความสำเร็จ');
            $table->string('footer_feature_4')->nullable()->after('footer_feature_3')->default('ใบประกาศนียบัตรรับรอง');

            // Contact Information
            $table->string('footer_contact_title')->default('ติดต่อเรา')->after('footer_feature_4');
            $table->string('footer_phone', 100)->nullable()->after('footer_contact_title')->default('xxx-xxx-xxxx');
            $table->string('footer_email')->nullable()->after('footer_phone')->default('contact@meta.com');
            $table->text('footer_address')->nullable()->after('footer_email')->default('กรุงเทพมหานคร ประเทศไทย');

            // Social Media Links
            $table->string('footer_facebook')->nullable()->after('footer_address');
            $table->string('footer_line')->nullable()->after('footer_facebook');
            $table->string('footer_instagram')->nullable()->after('footer_line');
            $table->string('footer_youtube')->nullable()->after('footer_instagram');

            // Copyright
            $table->text('footer_copyright')->nullable()->after('footer_youtube')->default('Meta Knowledge. All Rights Reserved. | Empowering Education, Inspiring Excellence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            $table->dropColumn([
                'show_footer',
                'footer_company_name',
                'footer_description_1',
                'footer_description_2',
                'footer_logo',
                'footer_about_title',
                'footer_feature_1',
                'footer_feature_2',
                'footer_feature_3',
                'footer_feature_4',
                'footer_contact_title',
                'footer_phone',
                'footer_email',
                'footer_address',
                'footer_facebook',
                'footer_line',
                'footer_instagram',
                'footer_youtube',
                'footer_copyright',
            ]);
        });
    }
};
