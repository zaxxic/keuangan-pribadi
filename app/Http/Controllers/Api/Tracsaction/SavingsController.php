<?php

namespace App\Http\Controllers\Api\Tracsaction;

use App\Http\Controllers\Controller;
use App\Mail\Invitation;
use App\Mail\InvitationApi;
use App\Models\HistorySaving;
use App\Models\Saving;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\RegularSaving;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use App\Models\HistoryTransaction;
use App\Models\User;


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
            'cover.in' => 'cover yang anda pilih tidak ada',
            'cover.required' => 'Cover wajib di isi',
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
    public function show(Saving $saving)
    {
        if (Gate::denies('members', $saving)) {
            return abort(401);
        }
        $histories = HistoryTransaction::whereHas('hasSaving', function ($q) use ($saving) {
            $q->where('saving_id', $saving->id);
        })->orderBy('created_at', 'DESC')->get();
        $data = [
            'saving' => $saving,
            'members' => collect([User::where('id', $saving->user_id)->first(), $saving->members])->flatten(1),
            'allHistories' => $histories->where('content', 'expenditure')
        ];
        $data['chartData'] = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => []
        ];

        $anggota = [];
        foreach ($data['members'] as $member) {
            $anggota[] = $member->id;
            array_push($data['chartData']['labels'], explode(' ', $member->name)[0]);
            $histories = $data['allHistories']->filter(function ($item) use ($member) {
                return $item->user_id == $member->id && $item->status == 'paid';
            });
            array_push($data['chartData']['data'], count($histories));
            array_push($data['chartData']['backgroundColor'], '#' . dechex(mt_rand(0, 16777215)));
        }

        $data['lainnya'] = HistorySaving::where("saving_id", $saving->id)->join('history_transactions as ht', 'history_savings.history_transaction_id', '=', "ht.id")->join("users as u", 'ht.user_id', '=', 'u.id')->select('u.name as name', 'ht.amount as amount', 'ht.date as date', 'ht.user_id as id')->where('ht.user_id', "!=", $anggota)->where('ht.content', 'expenditure')->orderBy('date', 'DESC')->get();

        $data['pengeluaran'] = HistorySaving::where("saving_id", $saving->id)->join('history_transactions as ht', 'history_savings.history_transaction_id', '=', "ht.id")->select('ht.amount as amount', 'ht.date as date')->where('ht.content', 'income')->orderBy('date', 'DESC')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saving $saving)
    {
        if (Gate::denies('owner', $saving)) {
            return abort(401);
        }

        return response()->json([
            'data' => $saving
        ], 200);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        // Validasi data dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'target_balance' => 'required',
            'description' => 'required|string|max:400',
            'inviteEmail.*' => 'required|email',
            'date' => 'required|date|after:today',
            'cover' => 'in:savings1.png,savings2.png,savings3.png,savings4.png,savings5.png|required',
            'payment_method' => 'required|string|in:E-Wallet,Cash,Debit',
            'recurring' => 'required|in:week,month,year',
            'amount' => 'required|lt:target_balance',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'target_balance.required' => 'Target harus diisi.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 400 karakter.',
            'inviteEmail.*.required' => 'Email harus diisi.',
            'cover.in' => 'cover yang anda pilih tidak ada',
            'cover.required' => 'Cover wajib di isi',
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Tanggal harus berupa tanggal yang valid.',
            'date.after' => 'Tanggal harus setelah hari ini.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.in' => 'Metode pembayaran tidak ada.',
            'recurring.required' => 'Jenis Metode harus diisi.',
            'recurring.in' => 'Jenis Metode tidak ada.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.lt' => 'Jumlah harus dibawah Target',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus boolean.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscribe = Auth::user()->subscribers->where('status', 'active')->first();

        if (!$subscribe && $request->input('status') != $saving->status) {
            $count = Auth::user()->memberOf->where('status', true)->count() + Auth::user()->savings->where('status', true)->count();
            if ($saving->status == true) {
                $count -= 1;
            }

            if ($count >= 3) {
                return response()->json(['message' => 'Anda sudah memiliki 3 tabungan aktif'], 422);
            }
        }

        $saving->update([
            'title' => $request->input('title'),
            'cover' => $request->input('cover'),
            'description' => $request->input('description'),
            'target_balance' => $request->input('target_balance'),
            'status' => $request->input('status'),
        ]);

        $saving->regular()->update([
            'amount' => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
            'recurring' => $request->input('recurring'),
            'date' => $request->input('date')
        ]);

        return response()->json(['message' => 'Tabungan berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        if ($saving) {
            if (Gate::allows('owner', $saving)) {
                $saving->delete();

                return response()->json([
                    'message' => 'Tabungan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses untuk menghapus tabungan ini',
                ], 422);
            }
        }
    }

    public function invite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format Email salah.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $saving = Saving::where('id', $request->input('saving'))->first();
        $email = $request->input('email');

        Mail::to($email)->send(new InvitationApi(Auth::user()->name, $saving->id, $saving->key));
        // error bangsat
        return response()->json([
            'message' => 'Email undangan telah terkirim'
        ]);
    }

    public function join(Request $request)
    {
        $saving = Saving::where('id', $request->get('id'))->first();
        if ($request->get('key') == $saving->key) {
            $user_id = Auth::user()->id;
            if ($user_id == $saving->user_id) {
                return redirect(route('savings.show', $saving->id));
            }

            $members = [];
            foreach ($saving->members->toArray() as $member) {
                $members[] = $member['id'];
            }

            if (in_array($user_id, $members)) {
                return redirect(route('savings.show', $saving->id));
            }

            $subscribe = Auth::user()->subscribers->where('status', 'active')->first();

            if (!$subscribe) {
                $count = Auth::user()->memberOf->where('status', true)->count() + Auth::user()->savings->where('status', true)->count();

                if ($count > 3) {
                    return abort(401, 'Anda sudah mencapai maksimum tabungan');
                }
            }

            $saving->members()->attach([
                $user_id
            ]);

            return redirect(route('savings.show', $saving->id));
        } else {
            return abort(401);
        }
    }
}
