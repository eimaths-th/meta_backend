<?php

namespace App\Services;

use RuntimeException;

class FormGradeLinkMapper
{
    /**
     * @param  array<int, int|string>|null  $linkedGrades
     * @param  array<int|string, int>  $gradeIdMap
     * @return array<int, int>|null
     */
    public function remap(?array $linkedGrades, array $gradeIdMap): ?array
    {
        if ($linkedGrades === null) {
            return null;
        }

        $remapped = [];

        foreach ($linkedGrades as $gradeId) {
            if (!array_key_exists($gradeId, $gradeIdMap)) {
                throw new RuntimeException(
                    "Package references grade {$gradeId}, which does not belong to the source form."
                );
            }

            $remapped[] = (int) $gradeIdMap[$gradeId];
        }

        return array_values(array_unique($remapped));
    }
}
