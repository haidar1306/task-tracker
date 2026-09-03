<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = $this->userNotifications()
            ->latest()
            ->paginate(10);

        return view(
            'frontend.notifications.index',
            compact('notifications')
        );
    }

    public function read($id)
    {
        $notification = $this->userNotifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return redirect($notification->data['url'] ?? route('frontend.user.dashboard'));
    }

    private function userNotifications()
    {
        return Auth::user()->notifications()->where(function ($query) {
            $query->where('data->audience', 'user')
                ->orWhere('data->type', 'inquiry_reply');
        });
    }
}
