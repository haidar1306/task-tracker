<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
 public function index(Request $request)
{
    $query = ActivityLog::query();


    // Search Description
    if ($request->search) {

        $query->where('description', 'like', '%' . $request->search . '%');

    }


    // Module Filter
    if ($request->module) {

        $query->where('module', $request->module);

    }


    // Action Filter
    if ($request->action) {

        $query->where('action', $request->action);

    }


    $activityLogs = $query
        ->latest('id')
        ->paginate(8)
        ->withQueryString();



    $modules = ActivityLog::select('module')
        ->distinct()
        ->pluck('module');


    $actions = ActivityLog::select('action')
        ->distinct()
        ->pluck('action');


    return view(
        'backend.activity-logs.index',
        compact(
            'activityLogs',
            'modules',
            'actions'
        )
    );
}
public function search(Request $request)
{
    $search = $request->search;


    $activityLogs = ActivityLog::query()
        ->when($search, function($query) use ($search){

            $query->where('description','like','%'.$search.'%');

        })
        ->latest('id')
        ->limit(20)
        ->get();



    return response()->json([
    'html' => view(
        'backend.activity-logs.partials.rows',
        [
            'activityLogs' => $activityLogs,
            'search' => $search,
        ]
    )->render(),
]);
}
}