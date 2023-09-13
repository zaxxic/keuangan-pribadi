<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularSaving extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function savingOf()
  {
    return $this->belongsTo(Saving::class);
  }
}
