<?php

namespace Tests\Unit;

use App\Models\ReceiptForm;
use App\Services\ReceiptLineItemResolver;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ReceiptLineItemResolverTest extends TestCase
{
    public function test_it_uses_the_package_id_saved_on_the_registration(): void
    {
        $resolver = $this->resolver([
            146 => ['sfield' => '56', 'package' => 'Young Sustainability Champion', 'price' => '890'],
        ]);

        $lines = $resolver->resolve(
            $this->form('56', '146', 'Young Sustainability Champion'),
            'Young Sustainability Champion',
        );

        $this->assertSame([[
            'description' => 'Young Sustainability Champion',
            'quantity' => 1,
            'unitprice' => 890,
        ]], $lines);
    }

    public function test_it_resolves_each_package_in_a_multi_package_registration(): void
    {
        $resolver = $this->resolver([
            98 => ['sfield' => '41', 'package' => 'Science', 'price' => '890'],
            100 => ['sfield' => '41', 'package' => 'English', 'price' => '890'],
        ]);

        $lines = $resolver->resolve($this->form('41', '[98,100]', 'Science, English'));

        $this->assertSame(['Science', 'English'], array_column($lines, 'description'));
        $this->assertSame([890, 890], array_column($lines, 'unitprice'));
    }

    public function test_it_blocks_a_missing_package_instead_of_creating_a_zero_price(): void
    {
        $this->expectException(RuntimeException::class);

        $this->resolver([])->resolve($this->form('56', '999', 'Unknown package'));
    }

    public function test_it_blocks_a_configured_zero_price(): void
    {
        $this->expectException(RuntimeException::class);

        $resolver = $this->resolver([
            153 => ['sfield' => '60', 'package' => 'Online total 10 Hr.', 'price' => '0'],
        ]);
        $resolver->resolve($this->form('60', '153', 'Online total 10 Hr.'));
    }

    public function test_it_keeps_the_legacy_test_field_price(): void
    {
        $lines = $this->resolver([])->resolve(
            $this->form('17', null, 'G9-Grade9 : 500 baht'),
        );

        $this->assertSame(500, $lines[0]['unitprice']);
    }

    public function test_legacy_price_parsing_ignores_parenthetical_numbers(): void
    {
        $lines = $this->resolver([])->resolve(
            $this->form('10', null, 'Test + tutoring class: 1250 bath (1 class 2 hours)'),
        );

        $this->assertSame(1250, $lines[0]['unitprice']);
    }

    private function resolver(array $packages): ReceiptLineItemResolver
    {
        return new ReceiptLineItemResolver(
            static function ($id, $sfield) use ($packages) {
                if (! isset($packages[$id]) || (string) $packages[$id]['sfield'] !== (string) $sfield) {
                    return null;
                }

                return (object) array_merge(['id' => $id], $packages[$id]);
            },
        );
    }

    private function form(string $sfield, ?string $packageId, string $package): ReceiptForm
    {
        $form = new ReceiptForm([
            'sfield' => $sfield,
            'package_id' => $packageId,
            'package' => $package,
        ]);
        $form->id = 123;

        return $form;
    }
}
