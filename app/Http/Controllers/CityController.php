<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with(['country', 'state'])->latest()->get();

        return view('backend.cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('backend.cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request)
    {
        City::create([
            ...$request->validated(),
            'name' => trim($request->name),
        ]);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City added successfully.');
    }

    public function edit(City $city)
    {
        $countries = Country::orderBy('name')->get();

        $states = State::where('country_id', $city->country_id)
            ->orderBy('name')
            ->get();

        return view('backend.cities.edit', compact(
            'city',
            'countries',
            'states'
        ));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update([
            $request->validated(),
            'name' => trim($request->name),
        ]);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()
            ->route('admin.cities.index')
            ->with('success', 'City deleted successfully.');
    }

    public function getStates($countryId)
    {
        return response()->json(
            State::where('country_id', $countryId)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}