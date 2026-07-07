<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifikasis = $user->notifications()
            ->latest()
            ->take(5)
            ->get()
            ->map(function($n) use ($user) {
                $url = $n->data['url'] ?? '#';
                // Jika url lama mengarah ke laporan_rpp tapi user adalah kepsek/admin, arahkan ke validasi
                if (($user->role === 'kepala' || $user->role === 'admin') && str_contains($url, '/laporan-rpp') && !str_contains($url, 'validasi-laporan')) {
                    $url = route('validasi_laporan');
                }
                
                return [
                    'id'       => $n->id,
                    'judul'    => $n->data['title'] ?? 'Notifikasi',
                    'pesan'    => $n->data['message'] ?? '',
                    'url'      => $url,
                    'icon'     => $n->data['icon'] ?? '',
                    'dibaca'   => !is_null($n->read_at),
                    'waktu'    => $n->created_at->locale('id')->diffForHumans(),
                ];
            });

        return response()->json([
            'status'        => true,
            'notifikasis'   => $notifikasis,
            'unread_count'  => $user->unreadNotifications()->count(),
        ]);
    }

    public function baca(string $id)
    {
        $notif = Auth::user()->notifications()->findOrFail($id);
        $notif->markAsRead();

        return response()->json(['status' => true]);
    }

    public function bacaSemua()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'status'  => true,
            'message' => 'Semua notifikasi telah ditandai dibaca.',
        ]);
    }

    public function webPush(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('WebPush endpoint hit', $request->all());
        
        Auth::user()->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'],
            $request->keys['auth']
        );

        return response()->json([
            'success' => true
        ]);
    }
}
