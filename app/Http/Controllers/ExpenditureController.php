<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $transactions = HistoryTransaction::where('user_id', $user->id)
            ->where('content', 'expenditure')

            ->get();

        return view('User.transaction.expenditure.expenditure', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.transaction.expenditure.add-expenditure');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date', 'date_before_today'],
            'description' => 'string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
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

        $user_id = Auth::id();
        $totalAmountSpent = HistoryTransaction::where('user_id', $user_id)->sum('amount');

        // Melakukan validasi total uang
        $requestedAmount = $request->input('amount');
        if ($requestedAmount > $totalAmountSpent) {
            // Jumlah yang dimasukkan melebihi total uang yang telah digunakan
            return response()->json(['errors' => ['amount' => 'Total uang tidak cukup']], 422);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/expenditure_attachment');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = null;
        }

        $user_id = Auth::id();

        $expenditure = new HistoryTransaction();
        $expenditure->title = $request->input('title');
        $expenditure->amount = $request->input('amount');
        $expenditure->payment_method = $request->input('payment_method');
        $expenditure->content = ('expenditure');
        $expenditure->date = $request->input('date');
        $expenditure->description = $request->input('description');
        $expenditure->category_id = $request->input('category_id');
        $expenditure->user_id = $user_id;
        $expenditure->attachment = $attachmentName;
        $expenditure->save();

        // Respon sukses
        return response()->json(['message' => 'Kategori pendapatan berhasil disimpan'], 200);
    }

    public function storeCatgory(Request $request)
    {
        // Validasi data yang dikirim oleh formulir
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $expenditureCategory = new Category();
        $expenditureCategory->name = $request->input('name');
        $expenditureCategory->content = 'expenditure';
        $expenditureCategory->type = 'local';
        $expenditureCategory->user_id = auth()->id();
        $expenditureCategory->save();

        return response()->json(['expenditureCategory' => $expenditureCategory]);
    }

    public function category()
    {

        $user = Auth::user();

        $expenditureCategories = Category::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere(function ($query) {
                    $query->where('type', 'default');
                });
        })
            ->select('id', 'name', 'created_at')
            ->where('content', 'expenditure')
            ->get();
        return response()->json(['expenditureCategories' => $expenditureCategories]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = HistoryTransaction::find($id); // Mengambil data transaksi berdasarkan ID

        if (!$transaction) {
        }

        // Memeriksa apakah pengguna yang saat ini masuk adalah pemilik data yang ingin diubah
        if ($transaction->user_id !== Auth::id()) {
            dd('forbiden');
        }
        return view('User.transaction.expenditure.edit-expenditure', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date', 'date_before_today'],
            'description' => 'string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cari transaksi berdasarkan ID
        $expenditure = HistoryTransaction::find($id);

        if (!$expenditure) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
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
        $expenditure->date = $request->input('date');
        $expenditure->description = $request->input('description');
        $expenditure->category_id = $request->input('category_id');
        $expenditure->save();

        // Respon sukses
        return response()->json(['message' => 'Transaksi berhasil diperbarui'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari transaksi berdasarkan ID
        $expenditure = HistoryTransaction::find($id);

        if (!$expenditure) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        // Hapus gambar lampiran jika ada
        if ($expenditure->attachment) {
            // Hapus gambar dari storage
            Storage::delete('public/expenditure_attachment/' . $expenditure->attachment);
        }

        // Hapus transaksi dari database
        $expenditure->delete();

        return response()->json(['success' => true]);
    }
}
