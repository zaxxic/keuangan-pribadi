<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notif = Notification::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->with('historyTransaction.category')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['notif' => $notif]);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        $transaction = HistoryTransaction::find($notification->history_transaction_id);
        $paymentBefore = $transaction->payment_method;

        $user_id = Auth::id();
        $totalAmountSpent = HistoryTransaction::where('user_id', $user_id)
            ->where('status', 'paid')
            ->sum('amount');

        $requiredAmount = $notification->historyTransaction->amount;

        if ($totalAmountSpent < $requiredAmount) {
            return response()->json(['message' => 'Saldo tidak mencukupi untuk melakukan transaksi'], 422);
        }
        // dd("bisa");

        $paymentMethod = $request->filled('payment_method') ? $request->input('payment_method') : $paymentBefore;

        $validator = Validator::make($request->all(), [
            'payment_method' => 'nullable|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'description' => 'string',
        ], [
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if (!$transaction) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }


        $transactionType = $transaction->content;

        $storageDirectory = ($transactionType === 'expenditure') ? 'public/reguler_expenditure_attachment' : 'public/reguler    _income_attachment';

        if ($request->hasFile('attachment')) {
            $newAttachment = $request->file('attachment');

            if ($transaction->attachment) {
                // Hapus baris berikut karena tidak perlu menghapus file yang ada
                // Storage::delete($storageDirectory . '/' . $transaction->attachment);
            }

            // Simpan file yang baru diunggah
            $attachmentPath = $newAttachment->store($storageDirectory);
            $attachmentName = basename($attachmentPath);

            // Update nama attachment di model transaksi
            $transaction->attachment = $attachmentName;
            $transaction->save(); // Simpan perubahan ke database
        }





        $transaction->payment_method = $paymentMethod;
        $transaction->description = $request->input('description');
        $transaction->save();

        // Update status notifikasi menjadi 'done'
        $notification->update([
            'status' => 'done',
        ]);

        // Jika notifikasi terkait dengan transaksi, perbarui status transaksi menjadi 'paid'
        if ($notification->historyTransaction) {
            $transaction->update([
                'status' => 'paid',
            ]);
        }

        return response()->json(['message' => 'Notifikasi berhasil diperbarui']);
    }



    public function accept($id)
    {
        $notification = Notification::find($id);
        $user_id = Auth::id();
        $totalAmountSpent = HistoryTransaction::where('user_id', $user_id)
            ->where('status', 'paid')
            ->sum('amount');

        $requiredAmount = $notification->historyTransaction->amount;

        if ($totalAmountSpent < $requiredAmount) {
            return response()->json(['message' => 'Saldo tidak mencukupi untuk melakukan transaksi'], 422);
        }
        // dd("bisa");

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
