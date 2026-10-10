<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StateManagementController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view('backend.state-management.index', compact('countries'));
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)
            ->orderBy('name')
            ->get(['id', 'name', 'country_id']);

        return response()->json($states);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => ['required', 'exists:countries,id'],

            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('states', 'name')
                    ->where(fn ($query) =>
                        $query->where('country_id', $request->country_id)
                    ),
            ],
        ]);

        $state = State::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'State added successfully.',
            'state' => $state,
        ]);
    }

    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('states', 'name')
                    ->where(fn ($query) =>
                        $query->where('country_id', $state->country_id)
                    )
                    ->ignore($state->id),
            ],
        ]);

        $state->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'State updated successfully.',
            'state' => $state,
        ]);
    }

    public function destroy(State $state)
    {
        $state->delete();

        return response()->json([
            'success' => true,
            'message' => 'State deleted successfully.',
        ]);
    }
}