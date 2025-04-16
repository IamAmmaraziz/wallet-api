<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;


    protected $fillable = [
        'amount',
        'type',
        'status',
        'user_id',
        'receiver_id',
    ];

    Public function user(){

        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
