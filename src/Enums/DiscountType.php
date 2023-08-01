<?php


namespace App\Enums;


final class DiscountType
{
    public const PERCENTAGE = 'percentage';
    public const MONEY = 'money';

    public static function converToArray()
    {
        return [
            self::PERCENTAGE,
            self::MONEY
        ];
    }
}