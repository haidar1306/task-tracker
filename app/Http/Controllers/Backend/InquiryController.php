<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Notifications\InquiryReplyNotification;
use App\Domains\Auth\Models\User;
use App\Models\Inquiry;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLogService $activityLog)
    {
        $this->activityLog = $activityLog;
    }
    public function index()
    {
        $inquiries = Inquiry::latest()->paginate(10);

        return view('backend.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('backend.inquiries.show', compact('inquiry'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }
    public function storeReply(Request $request, Inquiry $inquiry)
    {
        // dd($request->all());
        $request->validate([
            'reply' => 'required|string'
        ]);

        $inquiry->reply = $request->reply;
        $inquiry->replied_at = now();
        $inquiry->save();
        $this->activityLog->log(
            'Inquiry',
            'Replied',
            'Admin replied to Inquiry #' . $inquiry->id
        );

        $user = User::where('email', $inquiry->email)->first();

        // dd(DB::table('notifications')->latest()->first());
        if ($user) {
            $user->notify(new InquiryReplyNotification($inquiry));
        }

        return back()->with(
            'success',
            'Reply saved successfully.'
        );
    }
}