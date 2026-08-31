<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class NewServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();

        return view('frontend.services.index', compact('services'));
    }
    public function show(Service $service)
{
    return view('frontend.services.show', compact('service'));
}
}