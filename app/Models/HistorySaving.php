<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySaving extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function history()
  {
    return $this->belongsTo(HistoryTransaction::class);
  }

  public function savingOf()
  {
    return $this->belongsTo(Saving::class);
  }
}
