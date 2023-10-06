<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
// use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;


  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->id = Uuid::uuid4()->toString();
    });
  }

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';


  /**
   * The "type" of the primary key ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

  protected $guarded = [
    'id'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'last_verification_sent_time' => 'datetime',

  ];

  public function total()
  {
    $income = $this->histories()
      ->where('status', 'paid') // Menambahkan kondisi where untuk status "paid"
      ->where('content', 'income')
      ->sum('amount');

    $expenditure = $this->histories()
      ->where('status', 'paid') // Menambahkan kondisi where untuk status "paid"
      ->where('content', 'expenditure')
      ->sum('amount');

    return $income - $expenditure;
  }

  public function categories()
  {
    return $this->hasMany(Category::class);
  }

  public function subscribers()
  {
    return $this->hasMany(Subscriber::class);
  }

  public function savings()
  {
    return $this->hasMany(Saving::class);
  }

  public function regulars()
  {
    return $this->hasMany(RegularTransaction::class);
  }

  public function histories()
  {
    return $this->hasMany(HistoryTransaction::class);
  }

  function subscribe()
  {
    return $this->hasMany(Subscriber::class);
  }

  public function memberOf()
  {
    return $this->belongsToMany(Saving::class, 'saving_members', 'user_id', 'saving_id');
  }
}
