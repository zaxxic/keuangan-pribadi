<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HistoryTransaction;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Income\IncomeRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $incomeRepository;
    private $categoryRepository;

    public function __construct(IncomeRepository $incomeRepository, CategoryRepository $categoryRepository)
    {
        $this->incomeRepository = $incomeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            // Get income transactions for the authenticated user
            $transactions =  $this->incomeRepository->getIncome();

            $transactions->transform(function ($transaction) {
                $attachmentPath = $transaction->source === 'reguler' ? 'reguler_income_attachment/' : 'income_attachment/';
                $transaction->attachmentUrl = asset('storage/' . $attachmentPath . $transaction->attachment);
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



                ->addColumn('date', function ($row) {
                    $formattedDate = Carbon::parse($row->date)->format('d F Y');
                    $formattedDate = str_replace(
                        ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                        $formattedDate
                    );
                    return $formattedDate;
                })



                ->addColumn('action', function ($row) {
                    return '<div class="dropdown dropdown-action">
                                <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item edit-income" href="' . route('income.editing', ['id' => $row->id]) . '">Edit</a>
                                <a class="dropdown-item delete-income" href="#" data-id="' . $row->id . '" data-route="' . route('income.destroy', $row->id) . '">Delete</a>
                                </div>
                            </div>';
                })



                ->rawColumns(['attachment', 'action', 'description'])
                ->make(true);
        }
        return view('User.transaction.income.income');
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



        // Respon sukses
        return response()->json(['message' => 'Kategori pendapatan berhasil disimpan'], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.transaction.income.add-income');
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

    public function category()
    {

        $user = Auth::user();

        $incomeCategories = $this->categoryRepository->UserCetegoryIncome();
        return response()->json(['incomeCategories' => $incomeCategories]);
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
    // string $id

    public function editing($id)
    {

        $transaction = HistoryTransaction::find($id); // Mengambil data transaksi berdasarkan ID

        if (!$transaction) {
        }

        // Memeriksa apakah pengguna yang saat ini masuk adalah pemilik data yang ingin diubah
        if ($transaction === null || $transaction->user_id !== Auth::id()) {
            abort(404);
        }
        return view('User.transaction.income.edit-income', compact('transaction'));
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

        // Respon sukses
        return response()->json(['message' => 'Transaksi berhasil diperbarui'], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari transaksi berdasarkan ID
        $income = HistoryTransaction::find($id);

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
