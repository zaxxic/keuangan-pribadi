<?php

namespace App\Http\Controllers;

use App\Mail\Subscriber as MailSubscriber;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscribController extends Controller
{
    function store()
    {
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
        Mail::to($authenticatedUser->email)->send(new MailSubscriber($authenticatedUser->name, $expireDate));

        // Tambahkan langganan baru ke database
        $subscribe = new Subscriber();
        $subscribe->user_id = $authenticatedUserId;
        $subscribe->expire_date = $expireDate;
        $subscribe->status = 'active';
        $subscribe->save();

        return redirect()->back()->with('success', 'Anda berhasil berlangganan.');
    }
}
