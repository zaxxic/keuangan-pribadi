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

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Get income transactions for the authenticated user
            $transactions = HistoryTransaction::with('category')
                ->where('user_id', $user->id)
                ->where('content', 'income')
                ->where('status', 'paid')
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedTransactions = $transactions->map(function ($transaction) {
                $attachmentPath = $transaction->source === 'reguler' ? 'reguler_income_attachment/' : 'income_attachment/';
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

    public function filter(Request $request)
    {
        try {
            $user = Auth::user();
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $transactions = HistoryTransaction::with('category')
                ->where('user_id', $user->id)
                ->where('content', 'income')
                ->where('status', 'paid')
                ->when($startDate, function ($query) use ($startDate) {
                    return $query->whereDate('created_at', '>=', $startDate);
                })
                ->when($endDate, function ($query) use ($endDate) {
                    return $query->whereDate('created_at', '<=', $endDate);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedTransactions = $transactions->map(function ($transaction) {
                $attachmentPath = $transaction->source === 'reguler' ? 'reguler_income_attachment/' : 'income_attachment/';
                $transaction->attachmentUrl = asset('storage/' . $attachmentPath . $transaction->attachment);
                $transaction->amount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');
                $transaction->formattedDate = Carbon::parse($transaction->date)->format('d F Y');
                return $transaction;
            });
            // dd($transaction);
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
        $data = $request->all();
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



        // Respon sukses
        return response()->json([
            'message' => 'Pemasukan berhasil disimpan',
            'data' =>    $data
        ], 200);
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
            'message' => 'kategori berhasil disimpan',
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
            ->where('content', 'income')
            ->select('id', 'name', 'created_at')
            ->get();

        return response()->json(['incomeCategories' => $incomeCategories], 200);
    }

    public function edit($id)
    {

        $transaction = HistoryTransaction::find($id); // Mengambil data transaksi berdasarkan ID

        if (!$transaction) {
        }

        if ($transaction === null || $transaction->user_id !== Auth::id()) {
            abort(404);
        }

        if ($transaction->content === 'expenditure') {
            return response()->json(['message' => 'Akses ditolak untuk transaksi jenis Pengeluaran'], 403);
        }
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
        $income = HistoryTransaction::find($id);

        if (!$income) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($request->hasFile('attachment')) {
            // Menghapus lampiran lama jika ada
            if ($income->attachment) {
                Storage::delete('public/income_attachment/' . $income->attachment);
            }
            // Simpan lampiran baru
            $attachmentPath = $request->file('attachment')->store('public/income_attachment');
            $attachmentName = basename($attachmentPath);
            $income->attachment = $attachmentName;
        }

        $income->title = $request->input('title');
        $income->amount = $request->input('amount');
        $income->payment_method = $request->input('payment_method');
        $income->content = 'income';
        $income->status = 'paid';
        $income->source = 'normal';
        $income->date = $request->input('date');
        $income->description = $request->input('description');
        $income->category_id = $request->input('category_id');
        $income->save();

        $data = $request->all();

        return response()->json([
            'message' => 'Pemasukan berhasil di edit',
            'data' =>    $data
        ], 200);
    }

    public function destroy(string $id)
    {
        // Cari transaksi berdasarkan ID
        $income = HistoryTransaction::find($id);

        if ($income->content === 'expenditure') {
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
