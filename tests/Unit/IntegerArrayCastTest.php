<?php

namespace Tests\Unit;

use App\Casts\IntegerArray;
use PHPUnit\Framework\TestCase;

class IntegerArrayCastTest extends TestCase
{
    public function test_it_casts_json_array_values_to_integers(): void
    {
        $cast = new IntegerArray();

        $this->assertSame([1, 2, 3], $cast->get(null, 'linked_grades', '["1","2",3]', []));
    }

    public function test_it_returns_null_for_null_or_invalid_json(): void
    {
        $cast = new IntegerArray();

        $this->assertNull($cast->get(null, 'linked_grades', null, []));
        $this->assertNull($cast->get(null, 'linked_grades', '"not-an-array"', []));
    }

    public function test_it_encodes_array_values_as_integers_for_storage(): void
    {
        $cast = new IntegerArray();

        $this->assertSame('[4,5,6]', $cast->set(null, 'linked_grades', ['4', 5, '6'], []));
        $this->assertNull($cast->set(null, 'linked_grades', null, []));
    }
}
