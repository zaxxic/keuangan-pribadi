<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function historyTransaction()
    {
        return $this->belongsTo(HistoryTransaction::class);
    }
}
