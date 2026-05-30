<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $type = trim((string) $request->query('type', ''));
        $status = trim((string) $request->query('status', ''));

        $notifications = UserNotification::query()
            ->where('user_id', $user->id)
            ->when($type !== '', fn ($query) => $query->where('type', $type))
            ->when($status === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->when($status === 'read', fn ($query) => $query->whereNotNull('read_at'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $unreadCount = UserNotification::where('user_id', $user->id)->unread()->count();
        $typeCounts = UserNotification::where('user_id', $user->id)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('notifikasi.index', compact('notifications', 'unreadCount', 'typeCounts', 'type', 'status'));
    }

    public function markAsRead(Request $request, UserNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->markAsRead();

        return redirect('/notifikasi')->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead(Request $request)
    {
        UserNotification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect('/notifikasi')->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
