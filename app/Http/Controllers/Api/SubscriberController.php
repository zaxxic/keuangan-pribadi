<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TripayController;
use App\Models\Package;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubscriberController extends Controller
{
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
}
