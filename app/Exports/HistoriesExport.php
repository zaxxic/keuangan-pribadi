<?php

namespace App\Exports;

use App\Models\HistoryTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistoriesExport implements FromCollection
{
  protected $user, $month;

  public function __construct($user, $month)
  {
    $this->user = $user;
    $this->month = $month;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return HistoryTransaction::where("user_id", $this->user)->where("date", "like", "{$this->month}%")->orderBy("date", "DESC")->get();
  }
}
