<?php

namespace App\Services;

use App\Models\FormPakages;
use App\Models\ReceiptForm;
use RuntimeException;

class ReceiptLineItemResolver
{
    /** @var callable */
    private $packageFinder;

    public function __construct(?callable $packageFinder = null)
    {
        $this->packageFinder = $packageFinder ?: static function ($id, $sfield) {
            return FormPakages::whereKey($id)
                ->where('sfield', $sfield)
                ->first();
        };
    }

    /**
     * Resolve receipt lines from the package selection saved on the registration.
     *
     * @return array<int, array{description: string, quantity: int, unitprice: int}>
     */
    public function resolve(ReceiptForm $form, ?string $singleDescription = null): array
    {
        $packageIds = $this->packageIds($form->package_id);

        if ($packageIds !== []) {
            $lines = [];

            foreach ($packageIds as $packageId) {
                $package = ($this->packageFinder)($packageId, $form->sfield);

                if (! $package) {
                    throw new RuntimeException(
                        "Package {$packageId} was not found for form {$form->sfield}."
                    );
                }

                $price = $this->configuredPrice($package->price ?? null, $packageId);
                $lines[] = [
                    'description' => count($packageIds) === 1 && $singleDescription
                        ? $singleDescription
                        : (string) $package->package,
                    'quantity' => 1,
                    'unitprice' => $price,
                ];
            }

            return $lines;
        }

        return [$this->legacyLine($form, $singleDescription)];
    }

    /** @return array<int, int> */
    private function packageIds($rawPackageIds): array
    {
        $rawPackageIds = trim((string) $rawPackageIds);

        if ($rawPackageIds === '') {
            return [];
        }

        $decoded = json_decode($rawPackageIds, true);
        $values = is_array($decoded) ? $decoded : [$rawPackageIds];
        $ids = [];

        foreach ($values as $value) {
            $value = trim((string) $value);
            if ($value === '' || ! ctype_digit($value)) {
                throw new RuntimeException('The saved package selection is invalid.');
            }
            $ids[] = (int) $value;
        }

        return array_values(array_unique($ids));
    }

    private function configuredPrice($rawPrice, int $packageId): int
    {
        $normalized = preg_replace('/[^0-9.]/', '', (string) $rawPrice);

        if ($normalized === '' || ! is_numeric($normalized) || (float) $normalized <= 0) {
            throw new RuntimeException(
                "Package {$packageId} does not have a valid receipt price."
            );
        }

        return (int) round((float) $normalized);
    }

    /** @return array{description: string, quantity: int, unitprice: int} */
    private function legacyLine(ReceiptForm $form, ?string $singleDescription): array
    {
        $description = trim($singleDescription ?: (string) $form->package);

        // The original test field used grade numbers in the package label, so its
        // historical price cannot be safely parsed from the full label.
        if ((string) $form->sfield === '17') {
            $price = 500;
        } else {
            $priceSource = preg_replace('/\([^)]*\)/', '', (string) $form->package);
            $normalized = preg_replace('/[^0-9.]/', '', $priceSource);

            if ($normalized === '' || ! is_numeric($normalized) || (float) $normalized <= 0) {
                throw new RuntimeException(
                    "Registration {$form->id} does not have a resolvable receipt price."
                );
            }

            $price = (int) round((float) $normalized);
        }

        return [
            'description' => $description,
            'quantity' => 1,
            'unitprice' => $price,
        ];
    }
}
