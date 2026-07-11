<?php

namespace App\Domain\ValuesObject;

use App\Domain\ValuesObject\Trait\EnumTools;

enum ChequeType: string
{
    use EnumTools;

    case PAPER      = 'PAPER';
    case DIGITAL    = 'DIGITAL';

    public function label(): string
    {
        return match ($this) {
            self::PAPER     => 'کاغذی',
            self::DIGITAL   => 'دیجیتال',
        };
    }
}
