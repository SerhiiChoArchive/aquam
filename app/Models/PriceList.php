<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property array $fish
 * @property array $equipment
 * @property array $feed
 * @property array $chemistry
 * @property array $aquariums
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 */
class PriceList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getLatest(): ?PriceList
    {
        return self::query()->latest()->first();
    }

    public static function getPreLatest(): ?PriceList
    {
        return self::query()->orderBy('id', 'desc')->skip(1)->take(1)->first();
    }

    public function hasCategories(): bool
    {
        return !empty(array_sum([
            count($this->fish ?? []),
            count($this->equipment ?? []),
            count($this->feed ?? []),
            count($this->chemistry ?? []),
            count($this->aquariums ?? [])
        ]));
    }

    public static function getLatestCategory(string $category, ?int $api_version = 1): array
    {
        return self::query()
           ->select($category)
           ->where('api_version', $api_version)
           ->latest()
           ->first()
           ->{$category} ?? [];
    }

    public function setFishAttribute(array $fish): void
    {
        $this->attributes['fish'] = $fish ? json_encode($fish, JSON_UNESCAPED_UNICODE) : '';
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

    public function setAquariumsAttribute(array $aquariums): void
    {
        $this->attributes['aquariums'] = $aquariums ? json_encode($aquariums, JSON_UNESCAPED_UNICODE) : '';
    }

    public function getAquariumsAttribute(?string $aquariums): ?array
    {
        return $aquariums ? json_decode($aquariums, true) : null;
    }
}
