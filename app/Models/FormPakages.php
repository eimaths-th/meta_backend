<?php

namespace App\Models;

use App\Casts\IntegerArray;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $form_id
 * @property string $sfield
 * @property string $form_name
 * @property string $form_route
 * @property string $package
 * @property string $price
 * @property array $linked_grades
 * @property integer $create_by
 * @property integer $update_by
 * @property string $created_at
 * @property string $updated_at
 */
class FormPakages extends Model
{
    /**
     * @var array
     */

    protected $table = 'forms_pakages';

    protected $fillable = [
        'form_id',
        'sfield',
        'form_name',
        'form_route',
        'package',
        'price',
        'linked_grades',
        'create_by',
        'update_by',
        'created_at',
        'updated_at',
        'has_exam_mode',
        'online_limit',
        'onsite_limit',
        'online_registered',
        'onsite_registered',
    ];

    protected $casts = [
        'linked_grades' => IntegerArray::class,
        'has_exam_mode' => 'boolean',
        'online_limit' => 'integer',
        'onsite_limit' => 'integer',
        'online_registered' => 'integer',
        'onsite_registered' => 'integer',
    ];

    /**
     * Check if online slots are available for this package
     */
    public function hasAvailableOnlineSlots(): bool
    {
        if ($this->online_limit === null) {
            return true; // No limit set
        }
        return $this->online_registered < $this->online_limit;
    }

    /**
     * Check if onsite slots are available for this package
     */
    public function hasAvailableOnsiteSlots(): bool
    {
        if ($this->onsite_limit === null) {
            return true; // No limit set
        }
        return $this->onsite_registered < $this->onsite_limit;
    }

    /**
     * Get remaining online slots
     */
    public function getRemainingOnlineSlots(): ?int
    {
        if ($this->online_limit === null) {
            return null; // Unlimited
        }
        return max(0, $this->online_limit - $this->online_registered);
    }

    /**
     * Get remaining onsite slots
     */
    public function getRemainingOnsiteSlots(): ?int
    {
        if ($this->onsite_limit === null) {
            return null; // Unlimited
        }
        return max(0, $this->onsite_limit - $this->onsite_registered);
    }
}
