<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'transaction_id',
        'cheque_id',
        'payer_id',
        'receiver_id',
        'comment',
    ];
}
