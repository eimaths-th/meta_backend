<?php

namespace App\Support;

class FormBannerSettings
{
    public const DEFAULTS = [
        'fit' => 'auto',
        'desktop_height' => 240,
        'mobile_height' => 160,
        'position_x' => 50,
        'position_y' => 50,
    ];

    public const AUTO_MAX_HEIGHTS = ['desktop' => 360, 'mobile' => 240];

    public static function normalize(?array $settings): array
    {
        $settings = $settings ?? [];
        $resolved = self::DEFAULTS;
        if (in_array($settings['fit'] ?? null, ['auto', 'contain', 'cover'], true)) {
            $resolved['fit'] = $settings['fit'];
        }
        $bounds = [
            'desktop_height' => [120, 480],
            'mobile_height' => [100, 320],
            'position_x' => [0, 100],
            'position_y' => [0, 100],
        ];
        foreach ($bounds as $key => [$min, $max]) {
            if (isset($settings[$key]) && is_numeric($settings[$key])) {
                $resolved[$key] = max($min, min($max, (int) $settings[$key]));
            }
        }

        return $resolved;
    }
}
