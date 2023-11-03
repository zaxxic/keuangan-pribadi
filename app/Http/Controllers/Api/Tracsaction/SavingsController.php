<?php

namespace App\Http\Controllers\Api\Tracsaction;

use App\Http\Controllers\Controller;
use App\Mail\Invitation;
use App\Models\Saving;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\RegularSaving;
use Illuminate\Support\Facades\Mail;

class SavingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $s = '';
        if (request()->get('s')) {
            $s = request()->get('s');
        }
        $data = [
            // 'savings' => collect([Auth::user()->savings->sortByDesc('created_at'), Auth::user()->memberOf->sortByDesc('created_at')])->flatten(1)->paginate(2)->withQueryString()
            'savings' => Saving::where(function ($q) {
                $q->where('user_id', Auth::user()->id)->orWhereHas('members', function (Builder $q) {
                    $q->where('users.id', Auth::user()->id);
                });
            })->where(function ($q) use ($s) {
                $q->where('title', 'like', "%$s%")->orWhere('description', 'like', "%$s%");
            })->orderBy('created_at', 'DESC')->paginate(8)->withQueryString()
        ];
        return response()->json(['data' => $data], 200);
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
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'target_balance' => 'required',
            'description' => 'required|string|max:400',
            'inviteEmail.*' => 'required|email',
            'cover' => 'in:savings1.png,savings2.png,savings3.png,savings4.png,savings5.png|required',

            'date' => 'required|date|after:today',
            'payment_method' => 'required|string|in:E-Wallet,Cash,Debit',
            'recurring' => 'required|in:week,month,year',
            'amount' => 'required|lt:target_balance',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'target_balance.required' => 'Target harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 400 karakter.',
            'inviteEmail.*.required' => 'Email harus diisi.',

            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'date.after' => 'Tanggal harus setelah hari ini.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'recurring.required' => 'Jenis Metode harus diisi.',
            'recurring.in' => 'Jenis Metode tidak ada.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.lt' => 'Jumlah harus dibawah Target'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscribe = Auth::user()->subscribers->where('status', 'active')->first();

        if (!$subscribe) {
            $count = Auth::user()->memberOf->where('status', true)->count() + Auth::user()->savings->where('status', true)->count();


            if ($count >= 3) {
                return response()->json(['message' => 'Anda hanya dapat memiliki maksimal 3 tabungan bersama'], 422);
            }
        }

        // $saving = Saving::create([
        //   'title' => 'title',
        //   'cover' => 'cover',
        //   'description' => 'description',
        //   'target_balance' => 1000,
        //   'status' => true,
        //   'user_id' => Auth::user()->id
        // ]);

        // $saving->regular()->create([
        //   'amount' => 10,
        //   'payment_method' => 'payment_method',
        //   'recurring' => 'recurring',
        //   'date' => '2023-09-22'
        // ]);

        $saving = new Saving();
        $saving->title = $request->input('title');
        $saving->cover = $request->input('cover');
        $saving->description = $request->input('description');
        $saving->target_balance = $request->input('target_balance');
        $saving->status = true;
        $saving->key = Str::random(10);
        $saving->user_id = Auth::user()->id;
        $saving->save();

        $regular = new RegularSaving();
        $regular->amount = $request->input('amount');
        $regular->payment_method = $request->input('payment_method');
        $regular->recurring = $request->input('recurring');
        $regular->date = $request->input('date');
        $regular->saving_id = $saving->id;
        $regular->save();

        $emails = $request->input('inviteEmail');

        if ($emails > 0) {
            foreach ($emails as $email) {
                Mail::to($email)->send(new Invitation(Auth::user()->name, $saving->id, $saving->key));
            }
        }


        return response()->json(['message' => 'Tabungan baru berhasil disimpan'], 200);
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
