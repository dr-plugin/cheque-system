<?php

namespace App\Models;

use App\Domain\ValuesObject\Bank;
use App\Domain\ValuesObject\ChequeType;
use App\Models\Trait\PersianDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Morilog\Jalali\Jalalian;

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
        'due_date',
        'account_number',
        'is_registered'
    ];

    protected $casts = [
        'bank' => Bank::class,
        'type' => ChequeType::class,
    ];

    protected $appends = [
        'bank_label',
        'type_label',
        'date_fa', //presian date
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
            //get: fn($value) => $value !== null ? Jalalian::fromCarbon(Carbon::parse($value))->format('Y/m/d') : 'بدون تاریخ', //This method use when show date
            set: fn($value) => Jalalian::fromFormat('Y/m/d', $value)->toCarbon(),
        );
    }

    public function getBankLabelAttribute(): ?string
    {
        return $this->bank?->label();
    }

    public function getTypeLabelAttribute(): ?string
    {
        return $this->type?->label();
    }

    public function getDateFaAttribute(): string
    {
        return $this->due_date !== null ?
            Jalalian::fromCarbon(Carbon::parse($this->due_date))->format('Y/m/d')
            : 'بدون تاریخ';
    }
}
