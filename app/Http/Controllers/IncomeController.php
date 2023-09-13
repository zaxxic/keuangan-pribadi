<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HistoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $transactions = HistoryTransaction::where('user_id', $user->id)
            ->where('content', 'income')
            
            ->get();

        return view('User.transaction.income', compact('transactions'));
    }


    public function store(Request $request)
    {
        // Validasi data dengan pesan kustom
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'payment_method' => 'required|string|max:255',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.max' => 'Metode pembayaran tidak boleh lebih dari 255 karakter.',
            'attachment.required' => 'Bukti pembayaran harus diisi.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG,PNG atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

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
        $income->attachment = $attachmentName;
        $income->save();

        // Respon sukses
        return response()->json(['message' => 'Kategori pendapatan berhasil disimpan'], 200);
    }

    public function category()
    {

        $user = Auth::user();

        $incomeCategories = Category::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere(function ($query) {
                    $query->where('type', 'default');
                });
        })
            ->select('id', 'name', 'created_at')
            ->where('content', 'income')
            ->get();
        return response()->json(['incomeCategories' => $incomeCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.transaction.add-income');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCatgory(Request $request)
    {
        // Validasi data yang dikirim oleh formulir
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $incomeCategory = new Category();
        $incomeCategory->name = $request->input('name');
        $incomeCategory->content = 'income';
        $incomeCategory->type = 'local';
        $incomeCategory->user_id = auth()->id();
        $incomeCategory->save();

        return response()->json(['incomeCategory' => $incomeCategory]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
