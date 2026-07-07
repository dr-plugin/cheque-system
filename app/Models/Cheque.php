<?php

namespace App\Models;

use App\Models\Trait\PersianDate;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cheque extends Model
{
    use HasFactory, PersianDate;

    protected $fillable = [
        'price',
        'sayadi_number',
        'exporter',
        'comment',
        'bank',
        'img_url',
        'status',
        'type',
        'owner',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'owner', 'id');
    }

    public function ChequeLogs(): HasMany
    {
        return $this->hasMany(ChequeLogs::class, 'cheque_id');
    }


    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Jalalian::fromCarbon(Carbon::parse($value))->format('Y/m/d') : null,
            set: fn($value) => $value ? Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->toDateString() : null
        );
    }
}
