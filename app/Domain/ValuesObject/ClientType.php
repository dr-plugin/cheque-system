<?php

namespace App\Domain\ValuesObject;

enum ClientType: string
{
    case PAYER = 'payer';
    case RECEIVER = 'receiver';

    public function label(): string
    {
        return match ($this) {
            self::PAYER => 'پرداخت‌ کننده',
            self::RECEIVER => 'دریافت‌ کننده',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $item) => [
                'value' => $item->value,
                'label' => $item->label(),
            ],
            self::cases()
        );
    }
}
