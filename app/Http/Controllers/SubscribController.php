<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribController extends Controller
{
    function store()
    {
        $authenticatedUserId = Auth::user()->id;

        $latestSubscription = Subscriber::where('user_id', $authenticatedUserId)
            ->where('expire_date', '>', Carbon::now())
            ->latest('expire_date') // Urutkan berdasarkan expire_date dari yang terbaru ke yang terlama
            ->first();

        if ($latestSubscription) {
            return redirect()->back()->with('error', 'Anda sudah memiliki langganan aktif.');
        }

        $subscribe = new Subscriber();
        $subscribe->user_id = $authenticatedUserId;
        $subscribe->expire_date = Carbon::now()->addMonth();
        $subscribe->status = 'active';
        $subscribe->save();
        return back();
    }
}
