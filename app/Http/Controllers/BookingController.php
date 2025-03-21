<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\RoomService;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    private BookingService $bookingService;
    private RoomService $roomService;

    public function __construct(BookingService $bookingService, RoomService $roomService)
    {
        $this->bookingService = $bookingService;
        $this->roomService = $roomService;
    }

    public function index(): View
    {
        $bookings = $this->bookingService->getAll();

        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $rooms = $this->roomService->getAll();

        return view('bookings.create', compact('rooms'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            $this->bookingService->createMultiBooking($request->validated());

            return redirect()->route('bookings.index')->with('success', 'Booking successfully created.');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Booking $booking): View
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        $rooms = $this->roomService->getAll();
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->updateMultiBooking($booking, $request->validated());

            return redirect()->route('bookings.index')->with('success', 'Booking has been successfully updated.');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        try {
            $this->bookingService->delete($booking);

            return redirect()->route('bookings.index')->with('success', 'Booking successfully deleted.');
        } catch (Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function calendarEvents(): JsonResponse
    {
        $bookings = $this->bookingService->getAll();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->customer_name . ' (' . $booking->room->name . ')',
                'start' => $booking->start_time->toIso8601String(),
                'end' => $booking->end_time->toIso8601String(),
                'color' => $booking->status === 'confirmed' ? '#10B981' : ($booking->status === 'canceled' ? '#EF4444' : '#3B82F6'),
                'extendedProps' => [
                    'status' => $booking->status,
                    'room' => $booking->room->name,
                    'total_price' => $booking->total_price,
                ],
            ];
        });

        return response()->json($events);
    }
}
