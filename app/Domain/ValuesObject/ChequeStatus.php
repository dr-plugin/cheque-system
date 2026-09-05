<?php


namespace App\Domain\ValuesObject;

use App\Domain\ValuesObject\Trait\EnumTools;

enum ChequeStatus: string
{
    use EnumTools;

    case Pending = 'pending';
    case Cashed      = 'cashed';

    public function label(): string
    {
        return match ($this) {
            self::Cashed       => 'نقد شده',
            self::Pending  => 'دریافت شده',
        };
    }
}
