<?php

namespace App\Models;

use App\Models\Trait\PersianDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, PersianDate;

    protected $fillable = [
        'name',
        'phone',
        'type'
    ];

    public function cheques(): HasMany
    {
        return $this->hasMany(Cheque::class, 'owner');
    }
}
