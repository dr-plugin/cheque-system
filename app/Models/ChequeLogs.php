<?php

namespace App\Models;

use App\Models\Trait\PersianDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeLogs extends Model
{
    use HasFactory, PersianDate;

    protected $fillable = [
        'cheque_id',
        'payer_id',
        'receiver_id',
        'comment'
    ];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }
}
