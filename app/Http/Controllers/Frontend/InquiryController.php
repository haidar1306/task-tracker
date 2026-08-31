<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Domains\Auth\Models\User;
use App\Notifications\InquiryNotification;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLogService $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Activity Log
        $this->activityLog->log(
            'Inquiry',
            'Submitted',
            'Inquiry #' . $inquiry->id . ' submitted by ' . $inquiry->name
        );

        // Notify Admins
        $admins = User::where('type', User::TYPE_ADMIN)->get();

        foreach ($admins as $admin) {
            $admin->notify(new InquiryNotification($inquiry));
        }

        return back()->with(
            'success',
            'Inquiry submitted successfully.'
        );
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->email != auth()->user()->email) {
            abort(403);
        }

        return view(
            'frontend.inquiries.show',
            compact('inquiry')
        );
    }
}