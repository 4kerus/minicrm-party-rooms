<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\RoomService;
use App\Http\Requests\StoreRoomRequest;
use Exception;

class RoomController extends Controller
{
    private RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(): View
    {
        $rooms = $this->roomService->getAll();
        return view('rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('rooms.create');
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        try {
            $this->roomService->create($request->validated());

            return redirect()->route('rooms.index')->with('success', 'The room has been successfully created.');
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Error when creating a room: ' . $e->getMessage());
        }
    }

    public function show(Room $room): View
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(StoreRoomRequest $request, Room $room): RedirectResponse
    {
        try {
            $this->roomService->update($room, $request->validated());

            return redirect()->route('rooms.index')->with('success', 'The room has been successfully upgraded.');
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Error when updating a room: ' . $e->getMessage());
        }
    }

    public function destroy(Room $room): RedirectResponse
    {
        try {
            $this->roomService->delete($room);
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Error when deleting a room: ' . $e->getMessage());
        }

        return redirect()->route('rooms.index')->with('success', 'The room has been successfully deleted.');
    }

}
