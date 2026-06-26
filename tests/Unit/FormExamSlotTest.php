<?php

namespace Tests\Unit;

use App\Models\FormManage;
use App\Models\FormPakages;
use PHPUnit\Framework\TestCase;

class FormExamSlotTest extends TestCase
{
    public function test_form_manage_allows_slots_when_exam_mode_is_disabled(): void
    {
        $form = new FormManage([
            'enable_exam_mode' => false,
            'online_limit' => 1,
            'online_registered' => 1,
            'onsite_limit' => 1,
            'onsite_registered' => 1,
        ]);

        $this->assertTrue($form->HasAvailableOnlineSlots());
        $this->assertTrue($form->HasAvailableOnsiteSlots());
        $this->assertNull($form->GetOnlineRemainingSlots());
        $this->assertNull($form->GetOnsiteRemainingSlots());
    }

    public function test_form_manage_calculates_limited_remaining_slots(): void
    {
        $form = new FormManage([
            'enable_exam_mode' => true,
            'online_limit' => 10,
            'online_registered' => 7,
            'onsite_limit' => 5,
            'onsite_registered' => 5,
        ]);

        $this->assertTrue($form->HasAvailableOnlineSlots());
        $this->assertFalse($form->HasAvailableOnsiteSlots());
        $this->assertSame(3, $form->GetOnlineRemainingSlots());
        $this->assertSame(0, $form->GetOnsiteRemainingSlots());
    }

    public function test_package_slots_are_unlimited_when_limits_are_null(): void
    {
        $package = new FormPakages([
            'online_limit' => null,
            'online_registered' => 99,
            'onsite_limit' => null,
            'onsite_registered' => 99,
        ]);

        $this->assertTrue($package->hasAvailableOnlineSlots());
        $this->assertTrue($package->hasAvailableOnsiteSlots());
        $this->assertNull($package->getRemainingOnlineSlots());
        $this->assertNull($package->getRemainingOnsiteSlots());
    }

    public function test_package_slots_never_return_negative_remaining_counts(): void
    {
        $package = new FormPakages([
            'online_limit' => 2,
            'online_registered' => 3,
            'onsite_limit' => 4,
            'onsite_registered' => 1,
        ]);

        $this->assertFalse($package->hasAvailableOnlineSlots());
        $this->assertTrue($package->hasAvailableOnsiteSlots());
        $this->assertSame(0, $package->getRemainingOnlineSlots());
        $this->assertSame(3, $package->getRemainingOnsiteSlots());
    }
}
