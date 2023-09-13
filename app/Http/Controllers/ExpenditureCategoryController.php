<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\expenditure_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenditureCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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


        return view('User.menu.expenditure-category', compact('expenditureCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

        $expenditureCategory = new Category();
        $expenditureCategory->name = $request->input('name');
        $expenditureCategory->user_id = $request->input('user_id');
        $expenditureCategory->content = ('expenditure');
        $expenditureCategory->save();

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
        $category = Category::findOrFail($id);

        if (Auth::user()->id !== $category->user_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengedit kategori ini'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update data kategori
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Kategori pendapatan berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (Auth::user()->id !== $category->user_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengedit kategori ini'], 403);
        }

        if (!$category) {
            return response()->json(['error' => 'Kategori pendapatan tidak ditemukan.'], 404);
        }

        $category->delete();

        return response()->json(['success' => true]);
    }
}
