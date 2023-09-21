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

  protected $with = ['members'];

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
    return $this->belongsToMany(User::class, 'saving_members', 'saving_id', 'user_id');
  }
}
