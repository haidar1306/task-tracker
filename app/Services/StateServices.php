<?php

namespace App\Services;

use App\Models\State;
use Exception;
use Illuminate\Support\Facades\DB;

class StateServices
{
    public $model;

    public function __construct(State $state)
    {
        $this->model = $state;
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $state = $this->model->create($data);
            DB::commit();
            return $state;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(
                'Failed to create state: ' . $e->getMessage()
            );
        }
    }

    public function update(State $state, array $data)
    {
        DB::beginTransaction();
        try {
            $state->update($data);
            DB::commit();
            return $state;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(
                'Failed to update state: ' . $e->getMessage()
            );
        }
    }

    public function deleteState(State $state)
    {
        DB::beginTransaction();
        try {
            $state->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(
                'Failed to delete state: ' . $e->getMessage()
            );
        }
    }
    
    public function getStates()
    {
        return $this->model
            ->with('country')
            ->latest()
            ->get();
    }
}