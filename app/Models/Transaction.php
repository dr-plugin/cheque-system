<?php

namespace App\Models;

use App\Models\Trait\PersianDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cheque;

class Transaction extends Model
{
    use HasFactory, PersianDate;

    protected $fillable = [
        'price',
        'transaction_id',
        'cheque_id',
        'payer_id',
        'receiver_id',
        'comment',
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'payer_id', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'receiver_id', 'id');
    }

    public function cheque(): BelongsTo
    {
        return $this->belongsTo(Cheque::class, 'cheque_id', 'id');
    }
}
