<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $fish
 * @property string $equipment
 * @property string $feed
 * @property string $chemistry
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 */
class PriceList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function setFishAttribute(array $fish): void
    {
        if ($fish) {
            $this->attributes['fish'] = json_encode($fish, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['fish'] = '';
        }
    }

    public function getFishAttribute(?string $fish): ?array
    {
        return $fish ? json_decode($fish, true) : null;
    }

    public function setEquipmentAttribute(array $equipment): void
    {
        $this->attributes['equipment'] = $equipment ? json_encode($equipment, JSON_UNESCAPED_UNICODE) : '';
    }

    public function getEquipmentAttribute(?string $equipment): ?array
    {
        return $equipment ? json_decode($equipment, true) : null;
    }

    public function setFeedAttribute(array $feed): void
    {
        $this->attributes['feed'] = $feed ? json_encode($feed, JSON_UNESCAPED_UNICODE) : '';
    }

    public function getFeedAttribute(?string $feed): ?array
    {
        return $feed ? json_decode($feed, true) : null;
    }

    public function setChemistryAttribute(array $chemistry): void
    {
        $this->attributes['chemistry'] = $chemistry ? json_encode($chemistry, JSON_UNESCAPED_UNICODE) : '';
    }

    public function getChemistryAttribute(?string $chemistry): ?array
    {
        return $chemistry ? json_decode($chemistry, true) : null;
    }
}
