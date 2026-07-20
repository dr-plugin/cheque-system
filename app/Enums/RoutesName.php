<?php

namespace App\Enums;


enum RoutesName: string
{
    case Login = 'login';

    case CreateClient = '/client';
    case CreateCheque = '/cheque';
    case CreateTransaction = '/transaction';
}
