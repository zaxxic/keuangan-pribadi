<?php

namespace App\Http\Controllers;

use App\Models\Income_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Mengambil data income category yang terkait dengan user_id yang terautentikasi
        $incomeCategories = Income_category::where('user_id', $user->id)->get();

        return view('User.menu.income-category', compact('incomeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang diautentikasi

        if ($user) {
            $incomeCategories = $user->incomeCategories; // Mengambil kategori pendapatan terkait
            return response()->json($incomeCategories);
        } else {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required',
        ]);

        // Proses penyimpanan data
        $incomeCategory = new Income_category();
        $incomeCategory->name = $request->input('name');
        $incomeCategory->user_id = $request->input('user_id');
        $incomeCategory->save();

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
    public function destroy($id)
    {
        $category = Income_category::find($id);
        
        if (!$category) {
            return response()->json(['error' => 'Kategori pendapatan tidak ditemukan.'], 404);
        }

        $category->delete();

        return response()->json(['success' => true]);
    }
}
