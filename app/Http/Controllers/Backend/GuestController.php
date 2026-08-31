<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use App\Services\GuestService;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    protected $service;

    public function __construct(GuestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $guests = $this->service->all(5, $request->search);

        return view('backend.guests.index', compact('guests'));
    }

    public function create()
    {
        return view('backend.guests.create');
    }

    public function store(StoreGuestRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.guests.index')
            ->with('success', 'Guest created successfully.');
    }

    public function edit(Guest $guest)
    {
        return view('backend.guests.edit', compact('guest'));
    }

    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $this->service->update($guest, $request->validated());

        return redirect()
            ->route('admin.guests.index')
           ->withFlashSuccess('Room Updated Successfully.');
    }

    public function destroy(Guest $guest)
    {
        $this->service->delete($guest);

        return redirect()
            ->route('admin.guests.index')
            ->with('success', 'Guest deleted successfully.');
    }
}