<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCategoryIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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



        return view('Admin.income-category', compact('incomeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Pastikan user_id yang disimpan sama dengan id pengguna yang terautentikasi
        $authenticatedUserId = Auth::user()->id;
        $user_id = $request->input('user_id');

        if ($authenticatedUserId !== $user_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk menyimpan kategori dengan user_id ini'], 403);
        }

        $expenditureCategory = new Category();
        $expenditureCategory->name = $request->input('name');
        $expenditureCategory->user_id = $user_id;
        $expenditureCategory->type = 'default';
        $expenditureCategory->content = 'income';
        // dd('asd');
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
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if (Auth::user()->id !== $category->user_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengedit kategori ini'], 403);
        }
        // Validasi data jika diperlukan
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
    public function destroy($id)
    {
        $category = Category::find($id);

        if (Auth::user()->id !== $category->user_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengedit kategori ini'], 403);
        }

        if (!$category) {
            return response()->json(['error' => 'Kategori pendapatan tidak ditemukan.'], 404);
        }

        if (count($category->histories) > 0 || count($category->regulars) > 0) {
            return response()->json(['message' => 'Kategori sedang digunakan.'], 403);
        }

        $category->delete();

        return response()->json(['success' => true]);
    }
}
