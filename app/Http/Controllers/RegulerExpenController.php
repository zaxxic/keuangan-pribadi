<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularTransaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegulerExpenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $transactions = RegularTransaction::where('user_id', $user->id)
            ->where('content', 'expenditure')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($transactions);

        return view('User.transaction.reguler-expen.reguler-expen', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.transaction.reguler-expen.add-reguler');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'recurring' => 'required',
            'count' => 'required',
            'description' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date'],
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'recurring.required' => 'Perulangan harus di isi.',
            'count.required' => 'Jumlah perulangan harus diisi.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'attachment.required' => 'Bukti pembayaran harus diisi.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date_after_or_today' => 'Tanggal harus Setelah hari ini atau hari.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'category_id.required' => 'Kategori harus diisi.',
        ]);

        $user = Auth::user();
        $subscribe = $user->subscribers->where('status', 'active')->first();

        if (!$subscribe) {
            $incomeCount = RegularTransaction::where('user_id', $user->id)
                ->where('content', 'expenditure')
                ->count();

            if ($incomeCount >= 3) {
                return response()->json(['error' => 'Anda hanya dapat membuat maksimal 3 entri pengeluaran berencana'], 421);
            }
        }


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/reguler_expenditure_attachment');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = null;
        }

        $user_id = Auth::id();

        $expenditure = new RegularTransaction();
        $expenditure->title = $request->input('title');
        $expenditure->amount = $request->input('amount');
        $expenditure->recurring = $request->input('recurring');
        $expenditure->count = $request->input('count');
        $expenditure->real = $request->input('count');
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
        $transaction = RegularTransaction::find($id);

        if (!$transaction) {
        }

        if ($transaction === null || $transaction->user_id !== Auth::id()) {
            abort(404);
        }
        return view('User.transaction.reguler-expen.edit-reguler-expen', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'recurring' => 'required',
            'count' => 'required',
            'description' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date'],
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'recurring.required' => 'Perulangan harus di isi.',
            'count.required' => 'Jumlah perulangan harus diisi.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'description.required' => 'Deskripsi harus diisi.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'attachment.required' => 'Bukti pembayaran harus diisi.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date_after_or_today' => 'Tanggal harus Setelah hari ini atau hari.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'category_id.required' => 'Kategori harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $expenditure = RegularTransaction::find($id);

        if (!$expenditure) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($request->hasFile('attachment')) {
            if ($expenditure->attachment) {
                Storage::delete('public/reguler_expenditure_attachment/' . $expenditure->attachment);
            }

            $attachmentPath = $request->file('attachment')->store('public/reguler_expenditure_attachment');
            $attachmentName = basename($attachmentPath);
            $expenditure->attachment = $attachmentName;
        } else {

            $attachmentName = null;
        }

        $user_id = Auth::id();


        $expenditure->title = $request->input('title');
        $expenditure->amount = $request->input('amount');
        $expenditure->recurring = $request->input('recurring');
        $expenditure->count = $request->input('count');
        $expenditure->payment_method = $request->input('payment_method');
        $expenditure->content = ('expenditure');
        $expenditure->date = $request->input('date');
        $expenditure->description = $request->input('description');
        $expenditure->category_id = $request->input('category_id');
        $expenditure->user_id = $user_id;
        $expenditure->attachment = $attachmentName;
        $expenditure->save();

        return response()->json(['message' => 'Transaksi berhasil diperbarui'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $income = RegularTransaction::find($id);



        if (!$income) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($income->attachment) {
            Storage::delete('public/reguler_expenditure_attachment/' . $income->attachment);
        }

        $income->delete();

        return response()->json(['success' => true]);
    }
}
