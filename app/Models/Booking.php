<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
