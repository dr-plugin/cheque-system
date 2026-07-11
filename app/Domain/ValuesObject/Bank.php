<?php

/**
 * Iranian Banks List
 */

namespace App\Domain\ValuesObject;

use App\Domain\ValuesObject\Trait\EnumTools;

enum Bank: string
{
    use EnumTools;

    case Meli        = 'meli';
    case Saderat     = 'saderat';
    case Sepah       = 'sepah';
    case Refah       = 'refah';
    case Mellat      = 'mellat';
    case Tejarat     = 'tejarat';
    case Maskan      = 'maskan';
    case Keshavarzi  = 'keshavarzi';
    case Pasargad    = 'pasargad';
    case Saman       = 'saman';
    case Parsian     = 'parsian';
    case Sina        = 'sina';
    case Shahr       = 'shahr';
    case PostBank    = 'postbank';
    case Gardeshgari = 'gardeshgari';
    case KarAfarin   = 'karafarin';
    case BlueBank    = 'bluebank';

    /**
     * Translate banks
     */
    public function label(): string
    {
        return match ($this) {
            self::Meli        => 'بانک ملی ایران',
            self::Saderat     => 'بانک صادرات',
            self::Sepah       => 'بانک سپه',
            self::Refah       => 'بانک رفاه کارگران',
            self::Mellat      => 'بانک ملت',
            self::Tejarat     => 'بانک تجارت',
            self::Maskan      => 'بانک مسکن',
            self::Keshavarzi  => 'بانک کشاورزی',
            self::Pasargad    => 'بانک پاسارگاد',
            self::Saman       => 'بانک سامان',
            self::Parsian     => 'بانک پارسیان',
            self::Sina        => 'بانک سینا',
            self::Shahr       => 'بانک شهر',
            self::PostBank    => 'پست بانک ایران',
            self::Gardeshgari => 'بانک گردشگری',
            self::KarAfarin   => 'بانک کارآفرین',
            self::BlueBank    => 'بلو بانک',
        };
    }
  
}
