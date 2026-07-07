<?php

namespace App\Models;

use App\Models\Trait\PersianDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeLogs extends Model
{
    use HasFactory, PersianDate;

    protected $fillable = [
        'payer_id',
        'receiver_id',
    ];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }
}
