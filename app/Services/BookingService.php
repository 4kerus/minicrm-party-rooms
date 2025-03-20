<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{
    public function __construct()
    {
        $this->model = new Booking();
    }

    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $room = Room::query()->findOrFail($data['room_id']);
            $startTime = CarbonImmutable::parse($data['start_time']);
            $endTime = CarbonImmutable::parse($data['end_time']);

            $conflictExists = Booking::query()
                ->where('room_id', $room->id)
                ->where('status', '!=', 'canceled')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            if ($conflictExists) {
                throw new \Exception('Комната уже забронирована на это время.');
            }

            $hours = $startTime->diffInHours($endTime);
            $totalPrice = $room->price_per_hour * $hours;

            return Booking::query()->create([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'],
                'room_id' => $room->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_price' => $totalPrice,
                'status' => $data['status'] ?? 'pending',
            ]);
        });
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $startTime = CarbonImmutable::parse($data['start_time']);
            $endTime = CarbonImmutable::parse($data['end_time']);

            $conflictExists = Booking::query()
                ->where('room_id', $booking->room_id)
                ->where('status', '!=', 'canceled')
                ->where('id', '!=', $booking->id)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function ($query) use ($startTime, $endTime) {
                            $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            if ($conflictExists) {
                throw new \Exception('The new time overlaps with existing bookings.');
            }

            $hours = $startTime->diffInHours($endTime);
            $totalPrice = $booking->room->price_per_hour * $hours;

            $booking->update([
//                'customer_name' => $data['customer_name'],
//                'customer_phone' => $data['customer_phone'],
//                'customer_email' => $data['customer_email'],
//                'room_id' => $data['room_id'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_price' => $totalPrice,
                'status' => $data['status'],
            ]);

            return $booking->fresh();
        });
    }
}
