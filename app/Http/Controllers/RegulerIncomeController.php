<?php

namespace App\Http\Controllers;

use App\Models\RegularTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;




class RegulerIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            // Dapatkan transaksi pengeluaran untuk pengguna yang diautentikasi
            $transactions = RegularTransaction::with('category')
                ->where('user_id', $user->id)
                ->where('content', 'income')
                ->orderBy('created_at', 'desc')
                ->get();

            $transactions->transform(function ($transaction) {
                $attachmentPath = 'reguler_income_attachment/';
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
                ->addColumn('recurring', function ($row) {
                    if ($row->recurring === 'once') {
                        return 'Sekali';
                    } elseif ($row->recurring === 'daily') {
                        return 'Harian';
                    } elseif ($row->recurring === 'monthly') {
                        return 'Bulanan';
                    } elseif ($row->recurring === 'weekly') {
                        return 'Mingguan';
                    } elseif ($row->recurring === 'yearly') {
                        return 'Tahunan';
                    } else {
                        return 'Tidak Diketahui'; // Teks default jika nilai recurring tidak sesuai dengan yang diharapkan
                    }
                })

                ->addColumn('transaction_count', function ($row) {
                    return '<td>' . $row->count . '/' . $row->real . '</td>';
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
                                    <a class="dropdown-item edit-expenditure" href="' . route('reguler-income.edit', ['reguler_income' => $row->id]) . '">Edit</a>
                                    <a class="dropdown-item delete-income" href="#" data-id="' . $row->id . '" data-route="' . route('reguler-income.destroy', $row->id) . '">Delete</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['attachment', 'action', 'description', 'transaction_count', 'recurring'])
                ->make(true);
        }
        return view('User.transaction.reguler-income.reguler-income');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.transaction.reguler-income.add-reguler');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1001',
            'recurring' => 'required|in:once,daily,weekly,monthly,yearly',
            'count' => 'required',
            'description' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date'],
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'description.required' => 'Deskripsi harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah harus lebih dari 1000.',
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
                ->where('content', 'income')
                ->count();

            if ($incomeCount >= 3) {
                return response()->json(['error' => 'Anda hanya dapat membuat maksimal 3 entri pendapatan berencana'], 421);
            }
        }

        if ($request->input('recurring') === 'once' && $request->input('count') != 1) {
            return response()->json(['error' => 'Jika berulang sekali, jumlah perulangan harus 1.'], 424);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/reguler_income_attachment');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = null;
        }

        $user_id = Auth::id();

        $income = new RegularTransaction();
        $income->title = $request->input('title');
        $income->amount = $request->input('amount');
        $income->recurring = $request->input('recurring');
        $income->count = $request->input('count');
        $income->real = $request->input('count');
        $income->payment_method = $request->input('payment_method');
        $income->content = ('income');
        $income->date = $request->input('date');
        $income->description = $request->input('description');
        $income->category_id = $request->input('category_id');
        $income->user_id = $user_id;
        $income->attachment = $attachmentName;
        $income->save();



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
        return view('User.transaction.reguler-income.edit-reguler-income', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1001',
            'recurring' => 'required',
            'count' => 'required',
            'payment_method' => 'required|in:E-Wallet,Cash,Debit',
            'attachment' => 'image|mimes:jpeg,png,jpg|max:5120',
            'date' => ['required', 'date'],
            'category_id' => 'required',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah harus lebih dari 1000.',
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

        if ($request->input('recurring') === 'once' && $request->input('count') != 1) {
            return response()->json(['error' => 'Jika berulang sekali, jumlah perulangan harus 1.'], 424);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $income = RegularTransaction::find($id);

        if (!$income) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($request->hasFile('attachment')) {
            if ($income->attachment) {
                Storage::delete('public/reguler_income_attachment/' . $income->attachment);
            }

            $attachmentPath = $request->file('attachment')->store('public/reguler_income_attachment');
            $attachmentName = basename($attachmentPath);
            $income->attachment = $attachmentName;
        } else {

            $attachmentName = null;
        }

        $user_id = Auth::id();


        $income->title = $request->input('title');
        $income->amount = $request->input('amount');
        $income->recurring = $request->input('recurring');
        $income->count = $request->input('count');
        $income->payment_method = $request->input('payment_method');
        $income->content = ('income');
        $income->date = $request->input('date');
        $income->description = $request->input('description');
        $income->category_id = $request->input('category_id');
        $income->user_id = $user_id;
        $income->attachment = $attachmentName;
        $income->save();

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
            Storage::delete('public/reguler_income_attachment/' . $income->attachment);
        }

        $income->delete();

        return response()->json(['success' => true]);
    }
}
