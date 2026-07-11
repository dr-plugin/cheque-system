<?php


namespace App\Domain\ValuesObject;

use App\Domain\ValuesObject\Trait\EnumTools;

enum ChequeStatus: string
{

    case In_Cartable = 'in_cartable';
}
