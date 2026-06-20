<?php

namespace Tests\Unit;

use App\Services\FormGradeLinkMapper;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FormGradeLinkMapperTest extends TestCase
{
    public function test_it_remaps_source_grade_ids_to_new_grade_ids(): void
    {
        $mapper = new FormGradeLinkMapper();

        $this->assertSame(
            [799, 800, 801],
            $mapper->remap([747, 748, 749], [747 => 799, 748 => 800, 749 => 801]),
        );
    }

    public function test_it_preserves_null_for_packages_available_to_all_grades(): void
    {
        $mapper = new FormGradeLinkMapper();

        $this->assertNull($mapper->remap(null, []));
    }

    public function test_it_rejects_a_grade_that_does_not_belong_to_the_source_form(): void
    {
        $this->expectException(RuntimeException::class);

        (new FormGradeLinkMapper())->remap([747, 999], [747 => 799]);
    }
}
