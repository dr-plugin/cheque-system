<?php

namespace App\Domain\ValuesObject;

use App\Domain\ValuesObject\Trait\EnumTools;

enum TransactionType: string
{
    use EnumTools;

    case Payment    = 'Payment';
    case Cheque     = 'Cheque';
    case Adjustment = 'Adjustment';
    case Fee        = 'Fee';

    public function label(): string
    {
        return match ($this) {
            self::Payment       => 'پرداخت نقدی',
            self::Cheque        => 'انتقال چک',
            self::Adjustment    => 'اصلاحیه',
            self::Fee           => 'سود چک',
        };
    }
}
