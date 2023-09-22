<?php

namespace App\Http\Controllers\Saving;

use App\Http\Controllers\Controller;
use App\Models\HistorySaving;
use App\Models\HistoryTransaction;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = [
      'savings' => collect([Auth::user()->savings, Auth::user()->memberOf])->flatten(1)
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
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Saving $saving)
  {
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

    foreach($data['members'] as $member){
      array_push($data['chartData']['labels'], explode(' ', $member->name)[0]);
      $histories = $data['allHistories']->filter(function($item) use ($member){
        return $item->user_id == $member->id;
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
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Saving $saving)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Saving $saving)
  {
    //
  }
}
