<?php

namespace App\Http\Controllers\Saving;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\Invitation;
use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
use App\Models\RegularSaving;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SavingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $saving = Saving::find(13);

    // $saving->update([
    //   'title' => 'title',
    //   'cover' => 'cover',
    //   'description' => 'description',
    //   'target_balance' => 10,
    //   'status' => true,
    // ]);

    // $saving->regular()->update([
    //   'amount' => 10,
    //   'payment_method' => 'payment_method',
    //   'recurring' => 'recurring',
    //   'date' => '2022-09-22'
    // ]);


    $data = [
      'savings' => collect([Auth::user()->savings->sortByDesc('created_at'), Auth::user()->memberOf->sortByDesc('created_at')])->flatten(1)
    ];
    return view('User.transaction.savings.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('User.transaction.savings.add-savings');
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
      'date' => 'required|date|after_or_equal:today',
      'payment_method' => 'required|string|in:E-Wallet,Cash,Debit',
      'recurring' => 'required|in:week,month,year',
      'amount' => 'required',
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
      'date.after_or_equal:today' => 'Tanggal harus setelah hari ini atau hari ini.',
      'payment_method.required' => 'Metode pembayaran harus diisi.',
      'payment_method.string' => 'Metode pembayaran harus berupa teks.',
      'payment_method.in' => 'Metode pembayaran tidak ada.',
      'recurring.required' => 'Jenis Metode harus diisi.',
      'recurring.in' => 'Jenis Metode tidak ada.',
      'amount.required' => 'Jumlah harus diisi.',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
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

    if($emails > 0){
      foreach($emails as $email){
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
    $members = [];
    foreach($saving->members as $member){
      $members[] = $member['id'];
    }
    $members[] = $saving->user_id;
    if(!in_array(Auth::user()->id, $members)){
      return redirect(route('savings.index'));
    }
    $data = [
      'saving' => $saving,
      'members' => collect([User::where('id', $saving->user_id)->first(), $saving->members])->flatten(1),
      'allHistories' => HistoryTransaction::whereHas('hasSaving', function ($q) use ($saving) {
        $q->where('saving_id', $saving->id);
      })->orderBy('date', 'DESC')->get()
    ];
    $data['chartData'] = [
      'labels' => [],
      'data' => [],
      'backgroundColor' => []
    ];

    foreach ($data['members'] as $member) {
      array_push($data['chartData']['labels'], explode(' ', $member->name)[0]);
      $histories = $data['allHistories']->filter(function ($item) use ($member) {
        return $item->user_id == $member->id && $item->status == 'paid';
      });
      array_push($data['chartData']['data'], count($histories));
      array_push($data['chartData']['backgroundColor'], '#' . dechex(mt_rand(0, 16777215)));
    }

    return view('User.transaction.savings.detail-tabungan', $data);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Saving $saving)
  {
    if ($saving->user_id != Auth::user()->id) {
      return redirect(route('savings.index'));
    }
    return view('User.transaction.savings.edit-savings', ['saving' => $saving]);
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
      'date' => 'required|date|after_or_equal:today',
      'payment_method' => 'required|string|in:E-Wallet,Cash,Debit',
      'recurring' => 'required|in:week,month,year',
      'amount' => 'required',
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
      'date.after_or_equal:today' => 'Tanggal harus setelah hari ini atau hari ini.',
      'payment_method.required' => 'Metode pembayaran harus diisi.',
      'payment_method.string' => 'Metode pembayaran harus berupa teks.',
      'payment_method.in' => 'Metode pembayaran tidak ada.',
      'recurring.required' => 'Jenis Metode harus diisi.',
      'recurring.in' => 'Jenis Metode tidak ada.',
      'amount.required' => 'Jumlah harus diisi.',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $saving->update([
      'title' => $request->input('title'),
      'cover' => $request->input('cover'),
      'description' => $request->input('description'),
      'target_balance' => $request->input('target_balance')
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
      if ($saving->user_id == Auth::user()->id) {
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

    Mail::to($email)->send(new Invitation(Auth::user()->name, $saving->id, $saving->key));
    return response()->json([
      'message' => 'Email undangan telah terkirim'
    ]);
  }

  public function join(Request $request)
  {
    $saving = Saving::where('id', $request->get('id'))->first();
    if($request->get('key') == $saving->key){
      $user_id = Auth::user()->id;
      if($user_id == $saving->user_id){
        return redirect(route('savings.index'));
      }

      $members = [];
      foreach($saving->members->toArray() as $member){
        $members[] = $member['id'];
      }

      if(in_array($user_id, $members)){
        return redirect(route('savings.index'));
      }

      $saving->members()->attach([
        $user_id
      ]);

      return redirect(route('savings.show', $saving->id));
    } else {
      return redirect(route('savings.index'));
    }
  }

  public function out(Saving $saving)
  {
    $user_id = Auth::user()->id;
    if($user_id == $saving->user_id){
      return response()->json(['message' => 'Anda adalah pemilik tabungan ini'], 422);
    }

    $members = [];
    foreach($saving->members as $member){
      $members[] = $member['id'];
    }

    if(in_array($user_id, $members)){
      $saving->members()->detach($user_id);
      return response()->json(['message' => 'Anda berhasil keluar']);
    }
    return response()->json(['message' => 'Kesalahan internal'], 422);
  }

  public function kick(Request $request)
  {
    $saving = Saving::where('id', $request->post('saving_id'))->first();
    $user = $request->post('user_id');
    $user_id = Auth::user()->id;

    if($user_id != $saving->user_id){
      return response()->json(['message' => 'Anda tidak memiliki akses'], 422);
    }

    if($user == $user_id){
      return response()->json(['message' => 'Anda adalah ketua'], 422);
    }

    $saving->members()->detach($user);
    return response()->json(['message' => 'Kick berhasil'], 200);
  }
}
