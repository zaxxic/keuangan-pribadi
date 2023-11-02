<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HistoryTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            // Dapatkan transaksi pengeluaran untuk pengguna yang diautentikasi
            $transactions = HistoryTransaction::with('category')
                ->where('user_id', $user->id)
                ->where('content', 'expenditure')
                ->where('status', 'paid')
                ->orderBy('created_at', 'desc')
                ->get();
            $transactions->transform(function ($transaction) {
                $attachmentPath = $transaction->source === 'reguler' ? 'reguler_expenditure_attachment/' : 'expenditure_attachment/';
                $transaction->attachmentUrl = asset('storage/' . $attachmentPath . $transaction->attachment);
                $transaction->amount = 'Rp ' . number_format($transaction->amount, 0, ',', '.');
                return $transaction;
            });


            return Datatables::of($transactions)
                ->addIndexColumn()
                ->addColumn('attachment', function ($row) {
                    $modalTarget = $row->attachment ? '#modalImage' : '#modalImageEmptyAttachment';
                    return '<button data-bs-toggle="modal" data-bs-target="' . $modalTarget . '" 
                    data-bs-image="' . $row->attachmentUrl . '" 
                    class="btn btn-primary attachment-button">Lihat</button>';
                })
                ->addColumn('date', function ($row) {
                    $formattedDate = Carbon::parse($row->date)->format('d F Y');
                    // Ubah nama bulan dalam bahasa Indonesia
                    $formattedDate = str_replace(
                        ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                        $formattedDate
                    );
                    return $formattedDate;
                })
                ->addColumn('description', function ($row) {
                    $shortDescription = $row->description;
                    $showMoreLink = '';

                    if (strlen($row->description) > 45) {
                        $shortDescription = substr($row->description, 0, 45);
                        $showMoreLink = '<a href="javascript:void(0);" class="show-more-link">Selengkapnya</a>';
                    }

                    return '<div class="description-container">
                                <span class="description-text">' . $shortDescription . '</span>
                                <span class="description-full" style="display: none;">' . $row->description . '</span>
                                ' . $showMoreLink . '
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown dropdown-action">
                                <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item edit-expenditure" href="' . route('expenditure.edit', ['expenditure' => $row->id]) . '">Edit</a>
                                    <a class="dropdown-item delete-expenditure" href="#" data-id="' . $row->id . '" data-route="' . route('expenditure.destroy', $row->id) . '">Delete</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['attachment', 'action', 'description'])
                ->make(true);
        }
        return view('User.transaction.expenditure.expenditure');
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
            'amount' => 'required|numeric|min:1000',
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
            'attachment.required' => 'Bukti pembayaran harus diisi.',
            'attachment.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau JPEG.',
            'attachment.max' => 'Bukti pembayaran tidak boleh lebih dari 5 Mb.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date_before_today' => 'Tanggal harus sebelum hari ini atau hari.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'category_id.required' => 'Kategori harus diisi.',
        ]);

        $user_id = Auth::id();
        $totalAmountSpent = HistoryTransaction::where('user_id', $user_id)->sum('amount');
        $requestedAmount = $request->input('amount');
        // dd($totalAmountSpent, $requestedAmount);

        if ($validator->fails() || $requestedAmount > $totalAmountSpent) {
            $errors = $validator->errors();

            if ($requestedAmount > $totalAmountSpent) {
                $errors->add('amount', 'Total uang tidak cukup');
            }

            return response()->json(['errors' => $errors], 422);
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
        $expenditure->status = 'paid';
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
        return response()->json(['incomeCategories' => $expenditureCategories]);
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
        if ($transaction === null || $transaction->user_id !== Auth::id()) {
            abort(404);
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
            'amount' => 'required|numeric|min:1001',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date', 'date_before_today'],
            'description' => 'required|string',
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'description.required' => 'Deskripsi harus diisi.',
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

        $user_id = Auth::id();
        $totalAmountSpent = HistoryTransaction::where('user_id', $user_id)->sum('amount');
        $requestedAmount = $request->input('amount');

        if ($validator->fails() || $requestedAmount > $totalAmountSpent) {
            $errors = $validator->errors();

            if ($requestedAmount > $totalAmountSpent) {
                $errors->add('amount', 'Total uang tidak cukup');
            }

            return response()->json(['errors' => $errors], 422);
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
        $expenditure->source = 'noermal';
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
