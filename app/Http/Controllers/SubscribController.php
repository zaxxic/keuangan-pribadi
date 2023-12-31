<?php

namespace App\Http\Controllers;

use App\Mail\Subscriber as MailSubscriber;
use App\Models\Package;
use App\Models\Subscriber;
use App\Models\SubscriberTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscribController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $packages = Package::all();

        $subscribe = $user->subscribers->where('status', 'active')->first();

        if ($subscribe) {
            // dd($subscribe);
            return view('member.member-subscribed', compact('packages', 'subscribe'));
        } else {
            return view('member.member', compact('packages', 'subscribe'));
        }
    }
    function subscribe($id)
    {

        $tripay =  new TripayController();
        $channels = $tripay->getPaymentChannels();
        $package = Package::find($id);

        return view('member.payment', compact('channels', 'package'));
        $authenticatedUser = Auth::user();
        $authenticatedUserId = $authenticatedUser->id;

        $latestSubscription = Subscriber::where('user_id', $authenticatedUserId)
            ->where('expire_date', '>', Carbon::now())
            ->latest('expire_date')
            ->first();

        if ($latestSubscription) {
            return redirect()->back()->with('error', 'Anda sudah memiliki langganan aktif.');
        }

        $expireDate = Carbon::now()->addMonth();
        // Mail::to($authenticatedUser->email)->send(new Mai    lSubscriber($authenticatedUser->name, $expireDate));

        // Tambahkan langganan baru ke database
        $subscribe = new Subscriber();
        $subscribe->user_id = $authenticatedUserId;
        $subscribe->expire_date = $expireDate;
        $subscribe->status = 'active';
        $subscribe->save();

        // return redirect()->back()->with('success', 'Anda berhasil berlangganan.');
    }

    function show($reference)
    {
        $tripay = new TripayController();
        $detail = $tripay->detail($reference);
        $transaction = SubscriberTransaction::where('reference', $reference)->first();
        // dd($transaction);
        return view('member.payment-show', compact('transaction', 'detail'));
    }

    function store(Request $request)
    {
        $package = Package::find($request->package_id);
        $method = $request->method;
        $amount = $package->amount;
        $title = $package->title;

        $tripay = new TripayController();
        $transaction = $tripay->requestTransaction($method, $package);

        return redirect()->Route('transaction.show', ['reference' => $transaction->reference]);


        // $ref = $transaction->reference;
        // dd($transaction);
        // dd(json_decode($transaction)->data);
        // dd('asd');
        // return redirect()


    }
}
