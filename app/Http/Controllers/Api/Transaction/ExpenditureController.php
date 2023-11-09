<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HistoryTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExpenditureController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            // Get income transactions for the authenticated user
            $transactions = HistoryTransaction::with('category')
                ->where('user_id', $user->id)
                ->where('content', 'expenditure')
                ->where('status', 'paid')
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedTransactions = $transactions->map(function ($transaction) {
                $attachmentPath = $transaction->source === 'reguler' ? 'reguler_expenditure_attachment/' : 'expenditure_attachment/';
                $transaction->attachmentUrl = asset('storage/' . $attachmentPath . $transaction->attachment);
                $transaction->amount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');
                $transaction->formattedDate = Carbon::parse($transaction->date)->format('d F Y');
                return $transaction;
            });

            return response()->json([
                'status' => true,
                'message' => 'Data transaksi pendapatan ditemukan.',
                'data' => $formattedTransactions
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data transaksi pendapatan.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1001',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date', 'date_before_today'],
            'description' => 'required|string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah harus lebih dari 1000.',
            'description.required' => 'Deskripsi harus diisi.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'attachment.required' => 'Bukti pembayaran harus diisi.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date_before_today' => 'Tanggal harus sebelum hari ini atau hari.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'category_id.required' => 'Kategori harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/income_attachment');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = null;
        }

        $user_id = Auth::id();

        $income = new HistoryTransaction();
        $income->title = $request->input('title');
        $income->amount = $request->input('amount');
        $income->payment_method = $request->input('payment_method');
        $income->content = ('income');
        $income->date = $request->input('date');
        $income->description = $request->input('description');
        $income->category_id = $request->input('category_id');
        $income->user_id = $user_id;
        $income->status = 'paid';
        $income->attachment = $attachmentName;
        $income->save();

        $data = $request->all();

        // Respon sukses
        return response()->json([
            'message' => 'pengeluaran berhasil disimpan',
            'data' =>    $data
        ], 200);
    }

    public function category()
    {
        $user = Auth::user();

        $incomeCategories = Category::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('type', 'default');
        })
            ->where('content', 'expenditure')
            ->select('id', 'name', 'created_at')
            ->get();

        return response()->json(['incomeCategories' => $incomeCategories], 200);
    }

    public function storeCategory(Request $request)
    {
        // Validasi data yang dikirim oleh formulir
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $incomeCategory = new Category();
        $incomeCategory->name = $request->input('name');
        $incomeCategory->content = 'income';
        $incomeCategory->type = 'local';
        $incomeCategory->user_id = auth()->id();
        $incomeCategory->save();

        $data = $request->all();

        return response()->json([
            'message' => 'kategori pengeluaran berhasil disimpan',
            'data' =>    $data
        ], 200);
    }

    public function edit($id)
    {

        $transaction = HistoryTransaction::find($id); // Mengambil data transaksi berdasarkan ID

        if (!$transaction) {
        }

        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['message' => 'Anda tidak memiliki akses'], 403);
        }

        if ($transaction->content === 'income') {
            return response()->json(['message' => 'Akses ditolak untuk transaksi jenis pendapatan'], 403);
        }

        // return response()->json(['message' => 'income berhasil disimpan'], 200);
        return response()->json(['transaction' => $transaction], 200);
    }

    public function update(Request $request, $id)
    {
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1001',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date', 'date_before_today'],
            'description' => 'required|string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah harus lebih dari 1000.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date_before_today' => 'Tanggal harus sebelum hari ini atau hari.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'category_id.required' => 'Kategori harus diisi.',
        ]);

        // dd($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cari transaksi berdasarkan ID
        $expenditure = HistoryTransaction::find($id);

        if (!$expenditure) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($expenditure->content === 'income') {
            return response()->json(['message' => 'Akses ditolak untuk transaksi jenis pendapatan'], 403);
        }

        if ($request->hasFile('attachment')) {
            // Menghapus lampiran lama jika ada
            if ($expenditure->attachment) {
                Storage::delete('public/expenditure_attachment/' . $expenditure->attachment);
            }
            // Simpan lampiran baru
            $attachmentPath = $request->file('attachment')->store('public/expenditure_attachment');
            $attachmentName = basename($attachmentPath);
            $expenditure->attachment = $attachmentName;
        }

        $expenditure->title = $request->input('title');
        $expenditure->amount = $request->input('amount');
        $expenditure->payment_method = $request->input('payment_method');
        $expenditure->content = 'expenditure';
        $expenditure->status = 'paid';
        $expenditure->source = 'normal';
        $expenditure->date = $request->input('date');
        $expenditure->description = $request->input('description');
        $expenditure->category_id = $request->input('category_id');
        $expenditure->save();

        // Respon sukses
        $data = $request->all();

        return response()->json([
            'message' => 'pengeluaran berhasil di edit',
            'data' =>    $data
        ], 200);
    }

    public function destroy(string $id)
    {
        // Cari transaksi berdasarkan ID
        $income = HistoryTransaction::find($id);

        if ($income->content === 'income') {
            return response()->json(['message' => 'Akses ditolak untuk transaksi jenis Pengeluaran'], 403);
        }

        if (!$income) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        // Hapus gambar lampiran jika ada
        if ($income->attachment) {
            // Hapus gambar dari storage
            Storage::delete('public/income_attachment/' . $income->attachment);
        }

        // Hapus transaksi dari database
        $income->delete();

        return response()->json(['success' => true]);
    }
}
