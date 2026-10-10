<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->get();

        return view('backend.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('backend.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[A-Za-z\s]+$/',
                'unique:countries,name',
            ],

            'iso' => [
                'required',
                'string',
                'size:2',
                'regex:/^[A-Za-z]{2}$/',
                'unique:countries,iso',
            ],
        ]);

        Country::create($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('backend.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[A-Za-z\s]+$/',
                'unique:countries,name,' . $country->id,
            ],

            'iso' => [
                'required',
                'string',
                'size:2',
                'regex:/^[A-Za-z]{2}$/',
                'unique:countries,iso,' . $country->id,
            ],
        ]);

        $country->update($validated);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country deleted successfully.');
    }
}
