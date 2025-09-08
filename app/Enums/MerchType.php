<?php

namespace App\Enums;

enum MerchType: string
{
    case TSHIRTS = 'tshirts';
    case CAPS = 'caps';
    case WRISTBANDS = 'wristbands';
    case STICKERS = 'stickers';

    public function label(): string
    {
        return match($this) {
            self::TSHIRTS => 'T-Shirts',
            self::CAPS => 'Caps',
            self::WRISTBANDS => 'Wrist Bands',
            self::STICKERS => 'Stickers',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->label()];
        })->toArray();
    }
}