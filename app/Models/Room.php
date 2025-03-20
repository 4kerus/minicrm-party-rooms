<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_hour',
        'capacity'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
