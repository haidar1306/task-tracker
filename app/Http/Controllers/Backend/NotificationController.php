<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark notification as read and redirect
     */
        public function read($id)
        {
            $notification = auth()->user()
                ->notifications()
                ->where('id', $id)
                ->firstOrFail();

            // Mark notification as read
            $notification->markAsRead();

            // Get notification URL
            $url = $notification->data['url'] ?? route('admin.dashboard');

            // Redirect to notification related page
            return redirect($url);
        }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        // Delete notification
        $notification->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }
}