<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Income_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('User.transaction.income');
    }

    public function category()
    {

        $user = Auth::user();
        $incomeCategories = Income_category::where('user_id', $user->id)
            ->select('id', 'name') // Memilih hanya 'id' dan 'name'
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
            'name' => 'required|string|max:255|unique:income_categories',
        ]);

        // Simpan kategori pendapatan baru ke dalam database
        $incomeCategory = new Income_category();
        $incomeCategory->name = $request->input('name');
        $incomeCategory->user_id = auth()->id(); // Atur ID pengguna sesuai yang sedang masuk
        $incomeCategory->save();

        // Berikan respons JSON untuk mengembalikan kategori yang baru saja dibuat
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
