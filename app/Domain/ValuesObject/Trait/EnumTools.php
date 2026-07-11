<?php

namespace App\Domain\ValuesObject\Trait;

trait EnumTools
{

    /**
     * Save enum case to array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Create outputs for use in react tools
     */
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
