<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Notifications\InquiryNotification;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLogService $activityLog)
    {
        $this->activityLog = $activityLog;
    }
    protected function mine()
    {
        return Inquiry::where('email', auth()->user()->email);
    }

    public function index(Request $request)
    {
        $status = in_array($request->status, ['pending', 'replied']) ? $request->status : 'all';
        $search = trim((string) $request->q);

        $stats = [
            'all' => $this->mine()->count(),
            'pending' => $this->mine()->pending()->count(),
            'replied' => $this->mine()->replied()->count(),
            'unread' => $this->mine()->unreadReply()->count(),
        ];

        $inquiries = $this->mine()
            ->when($status === 'pending', fn($q) => $q->pending())
            ->when($status === 'replied', fn($q) => $q->replied())
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('frontend.inquiries.index', compact('inquiries', 'stats', 'status', 'search'));
    }
    /** Ajax: drawer ke liye detail card (HTML partial) return karta hai. */
    public function detail($id)
    {
        $inquiry = $this->mine()->findOrFail($id); // dusre user ki inquiry => 404

        if ($inquiry->is_unread_reply) {
            $inquiry->forceFill(['reply_read_at' => now()])->save();
        }

        return response()->json([
            'html' => view('frontend.inquiries._detail', compact('inquiry'))->render(),
            'unread' => $this->mine()->unreadReply()->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Email form se nahi, logged-in user se (form edit karke dusre ke naam se inquiry na bane)
        $inquiry = Inquiry::create([
            'name' => $data['name'],
            'email' => $request->user()->email,
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        $this->activityLog->log(
            'Inquiry',
            'Submitted',
            'Inquiry #' . $inquiry->id . ' submitted by ' . $inquiry->name
        );

        // Notification fail ho to bhi inquiry save rahe aur user ko success dikhe
        try {
            User::where('type', User::TYPE_ADMIN)->get()
                ->each(fn(User $admin) => $admin->notify(new InquiryNotification($inquiry)));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->withFlashSuccess(
            'Your inquiry has been sent successfully. We will get back to you soon.'
        );
    }

    public function show(Inquiry $inquiry)
    {
        abort_unless(
            auth()->check()
            && strcasecmp((string) $inquiry->email, (string) auth()->user()->email) === 0,
            403
        );

        return view('frontend.inquiries.show', compact('inquiry'));
    }
}