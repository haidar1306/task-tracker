<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('backend.services.index', compact('services'));
    }

    public function create()
    {
        return view('backend.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|max:500',
            'description' => 'nullable',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/services'), $imageName);
        }

        Service::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'icon' => $request->icon,
            'image' => $imageName,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }
    public function edit(Service $service)
{
    return view('backend.services.edit', compact('service'));
}



public function update(Request $request, Service $service)
{
    $request->validate([
        'title' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'short_description' => 'nullable|max:500',
        'description' => 'nullable',
    ]);

    $imageName = $service->image;

    if ($request->hasFile('image')) {

        if ($service->image && File::exists(public_path('uploads/services/'.$service->image))) {
            File::delete(public_path('uploads/services/'.$service->image));
        }

        $image = $request->file('image');

        $imageName = time().'.'.$image->getClientOriginalExtension();

        $image->move(public_path('uploads/services'), $imageName);
    }

    $service->update([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'icon' => $request->icon,
        'image' => $imageName,
        'short_description' => $request->short_description,
        'description' => $request->description,
        'status' => $request->status,
        'sort_order' => $request->sort_order,
    ]);

    return redirect()->route('admin.services.index')
        ->with('success','Service updated successfully.');
}
public function destroy(Service $service)
{
    if ($service->image && File::exists(public_path('uploads/services/'.$service->image))) {
        File::delete(public_path('uploads/services/'.$service->image));
    }

    $service->delete();

    return redirect()->route('admin.services.index')
        ->with('success','Service deleted successfully.');
}




}