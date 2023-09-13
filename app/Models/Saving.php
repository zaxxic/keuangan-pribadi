<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function regular()
  {
    return $this->hasOne(RegularSaving::class);
  }

  public function histories()
  {
    return $this->hasMany(HistorySaving::class);
  }

  public function members()
  {
    return $this->belongsToMany(SavingMember::class, 'saving_member');
  }
}
