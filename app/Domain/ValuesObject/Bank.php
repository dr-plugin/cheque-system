<?php
/**
 * Iranian Banks List
 */
namespace App\Domain\ValuesObject;

enum Bank: string
{
    case Meli       = 'meli';
    case Saderat    = 'saderat';
    case Sepah      = 'sepah';
    case Refah      = 'Refah';
}
