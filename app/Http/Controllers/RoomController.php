<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\RoomService;
use App\Http\Requests\RoomRequest;
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

    public function store(RoomRequest $request): RedirectResponse
    {
        try {
            $this->roomService->create($request->validated());

            return redirect()->route('rooms.index')->with('success', 'Комната успешно создана.');
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Ошибка при создании комнаты: ' . $e->getMessage());
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

    public function update(RoomRequest $request, Room $room): RedirectResponse
    {
        try {
            $this->roomService->update($room, $request->validated());

            return redirect()->route('rooms.index')->with('success', 'Комната успешно обновлена.');
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Ошибка при обновлении комнаты: ' . $e->getMessage());
        }
    }

    public function destroy(Room $room): RedirectResponse
    {
        try {
            $this->roomService->delete($room);
        } catch (Exception $e) {

            return redirect()->route('rooms.index')->with('error', 'Ошибка: ' . $e->getMessage());
        }

        return redirect()->route('rooms.index')->with('success', 'Комната успешно удалена.');
    }
}
