<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{
    public function __construct()
    {
        $this->model = new Booking();
    }

    public function getAll(): Collection
    {
        $bookings = $this->model::with('rooms')->get();

        foreach ($bookings as $booking) {
            $roomCount = $booking->rooms->count();

            if ($roomCount >= 2) {
                $totalPrice = 0;

                foreach ($booking->rooms as $index => $room) {
                    $discount = 0;

                    if ($index === 1) {
                        $discount = 0.10;
                    } elseif ($index >= 2) {
                        $discount = 0.20;
                    }

                    if (isset($room->price_per_hour)) {
                        $totalPrice += $room->price_per_hour * (1 - $discount);
                    }
                }

                $booking->total_price = $totalPrice;
            }
        }

        return $bookings;
    }

    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $startTime = CarbonImmutable::parse($data['start_time']);
            $endTime = CarbonImmutable::parse($data['end_time']);
            $hours = $startTime->diffInHours($endTime);

            foreach ($data['room_ids'] as $roomId) {
                $room = Room::query()->findOrFail($roomId);

                if ($this->hasBookingConflict($room->id, $startTime, $endTime)) {
                    throw new Exception("Room {$room->id} is already booked at this time.");
                }
            }

            $totalPrice = 0;
            foreach ($data['room_ids'] as $roomId) {
                $room = Room::query()->findOrFail($roomId);
                $totalPrice += $room->price_per_hour * $hours;
            }

            $booking = Booking::query()->create([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_price' => $totalPrice,
                'status' => $data['status'] ?? 'pending',
            ]);

            $booking->rooms()->attach($data['room_ids']);

            return $booking;
        });
    }

    public function updateBooking(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $startTime = CarbonImmutable::parse($data['start_time']);
            $endTime = CarbonImmutable::parse($data['end_time']);
            $hours = $startTime->diffInHours($endTime);

            foreach ($data['room_ids'] as $roomId) {
                if ($this->hasBookingConflict($roomId, $startTime, $endTime, $booking->id)) {
                    throw new Exception("Room {$roomId} is already booked at this time.");
                }
            }

            $totalPrice = 0;
            foreach ($data['room_ids'] as $roomId) {
                $room = Room::query()->findOrFail($roomId);
                $totalPrice += $room->price_per_hour * $hours;
            }

            $booking->update([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_price' => $totalPrice,
                'status' => $data['status'] ?? $booking->status,
            ]);

            $booking->rooms()->sync($data['room_ids']);

            return $booking->fresh();
        });
    }

    private function hasBookingConflict(int $roomId, CarbonImmutable $startTime, CarbonImmutable $endTime, ?int $excludeBookingId = null): bool
    {
        $query = Booking::query()
            ->whereHas('rooms', function ($query) use ($roomId) {
                $query->where('booking_rooms.room_id', $roomId);
            })
            ->where('status', '!=', 'canceled');

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                ->orWhereBetween('end_time', [$startTime, $endTime])
                ->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
        })->exists();
    }
}
