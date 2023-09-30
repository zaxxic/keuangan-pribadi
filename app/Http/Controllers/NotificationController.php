<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notif = Notification::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->with('historyTransaction.category')
            ->get();


        return response()->json(['notif' => $notif]);
    }



    public function accept($id)
    {
        $notification = Notification::find($id);

        // Periksa apakah notifikasi ditemukan
        if (!$notification) {
            return response()->json(['message' => 'Notifikasi tidak ditemukan'], 404);
        }

        // Pastikan hanya pemilik notifikasi yang dapat memperbarui statusnya
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update status notifikasi menjadi 'done'
        $notification->update([
            'status' => 'done',
        ]);

        // Jika notifikasi terkait dengan transaksi, maka juga perbarui status transaksi menjadi 'paid'
        if ($notification->historyTransaction) {
            $transaction = $notification->historyTransaction;
            $transaction->update([
                'status' => 'paid',
            ]);
        }

        return response()->json(['message' => 'Status notifikasi dan transaksi berhasil diperbarui']);
    }
}
