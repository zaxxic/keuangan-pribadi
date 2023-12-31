<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransaction extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function hasSaving()
  {
    return $this->hasOne(HistorySaving::class);
  }

  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }
}
