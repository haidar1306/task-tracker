<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;

use App\Http\Requests\UpdateStateRequest;
use App\Http\Requests\StoreStateRequest;


class StateController extends Controller
{
    public function index() 
    {
        $states = State::with('country')->latest()->get();

        return view('backend.states.index', compact('states'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('backend.states.create', compact('countries'));
    }

   public function store(StoreStateRequest $request)
    {
        State::create($request->validated());
        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State created successfully.');
    }

    public function edit(State $state)
    {
        $countries = Country::orderBy('name')->get();

        return view('backend.states.edit', compact('state', 'countries'));
    }

 public function update(UpdateStateRequest $request, State $state)
    {
        $state->update($request->validated());

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State deleted successfully.');
    }
}