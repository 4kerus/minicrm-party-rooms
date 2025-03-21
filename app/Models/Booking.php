<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'room_id',
        'start_time',
        'end_time',
        'total_price',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'booking_rooms', 'booking_id', 'room_id');
    }
}
