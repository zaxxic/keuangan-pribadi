<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\SubscriberTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailSubscriber;
use App\Mail\Package;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

// use App\Models\transaction;


class CallBackController extends Controller
{

    protected $privateKey = 'vcxxb-129uG-Z81zU-7Aafn-VNwnv';

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);
        // dd($data)

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $transactionId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);
        // dd($data);

        if ($data->is_closed_payment === 1) {
            $transaction = SubscriberTransaction::where('reference', $tripayReference)
                ->where('reference', $tripayReference)
                ->where('status', '=', 'UNPAID')
                ->first();

            // dd($title);

            if (!$transaction) {
                return Response::json([
                    'success' => false,
                    'message' => 'No transaction found or already paid: ' . $transactionId,
                ]);
            }

            switch ($status) {
                case 'PAID':
                    $transaction->update(['status' => 'PAID']);

                    // $authenticatedUser = Auth::user();
                    // $authenticatedUserId = $authenticatedUser->id;
                    $authenticatedUserId = $transaction->user_id;
                    $amount = $transaction->amount;
                    $user = $transaction->user;
                    $title = $transaction->package->title;
                    $bonus = $transaction->package->bonus;
                    $jenis = $transaction->package->id;


                    $latestSubscription = Subscriber::where('user_id', $authenticatedUserId)
                        ->where('expire_date', '>', Carbon::now())
                        ->latest('expire_date')
                        ->first();

                    if ($latestSubscription) {
                        return redirect()->back()->with('error', 'Anda sudah memiliki langganan aktif.');
                    }

                    if ($jenis == 1) {
                        $duration = 2; // 2 bulan
                    } elseif ($jenis == 2) {
                        $duration = 17; // 1 tahun + 5 bulan
                    } elseif ($jenis == 3) {
                        $duration = 9; // 9 bulan
                    } else {
                        // Atur durasi default jika jenis tidak valid
                        $duration = 0;
                    }

                    $expireDate = Carbon::now()->addMonths($duration);
                    // Mail::to($user->email)->send(new MailSubscriber($user->name, $expireDate));
                    Mail::to($user->email)->send(new Package($user->name, $expireDate));
                    // Tambahkan langganan baru ke database
                    $subscribe = new Subscriber();
                    $subscribe->user_id = $authenticatedUserId;
                    $subscribe->expire_date = $expireDate;
                    $subscribe->amount = $amount;
                    $subscribe->title = $title;
                    $subscribe->bonus = $bonus;
                    $subscribe->status = 'active';
                    $subscribe->save();
                    break;

                case 'EXPIRED':
                    $transaction->update(['status' => 'EXPIRED']);
                    break;

                case 'FAILED':
                    $transaction->update(['status' => 'FAILED']);
                    break;

                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }

            return Response::json(['success' => true]);
        }
    }
}
