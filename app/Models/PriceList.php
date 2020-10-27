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
}
