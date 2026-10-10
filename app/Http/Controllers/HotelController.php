<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with([
            'country',
            'state',
            'city'
        ])
        ->latest()
        ->get();

        return view('backend.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('backend.hotels.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => [
                'required',
                'exists:countries,id',
            ],

            'state_id' => [
                'required',
                'exists:states,id',
            ],

            'city_id' => [
                'required',
                'exists:cities,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('hotels', 'name')
                    ->where('city_id', $request->city_id),
            ],
        ]);

        Hotel::create($validated);

        return redirect()
            ->route('admin.hotels.index')
            ->with('success', 'Hotel added successfully.');
    }

    public function edit(Hotel $hotel)
    {
        $countries = Country::orderBy('name')->get();

        $states = State::where(
            'country_id',
            $hotel->country_id
        )
        ->orderBy('name')
        ->get();

        $cities = City::where(
            'state_id',
            $hotel->state_id
        )
        ->orderBy('name')
        ->get();

        return view(
            'backend.hotels.edit',
            compact('hotel', 'countries', 'states', 'cities')
        );
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'country_id' => [
                'required',
                'exists:countries,id',
            ],

            'state_id' => [
                'required',
                'exists:states,id',
            ],

            'city_id' => [
                'required',
                'exists:cities,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('hotels', 'name')
                    ->where('city_id', $request->city_id)
                    ->ignore($hotel->id),
            ],
        ]);

        $hotel->update($validated);

        return redirect()
            ->route('admin.hotels.index')
            ->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()
            ->route('admin.hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }

    public function getStates($countryId)
    {
        return response()->json(
            State::where('country_id', $countryId)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    public function getCities($stateId)
    {
        return response()->json(
            City::where('state_id', $stateId)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}