<?php

declare(strict_types=1);

namespace app\core;

class Formatter
{
    public static function formatAmountForIndex(float $amount): string
    {
        return ($amount >= 0 ? '' : '-') . '$' . number_format(abs($amount), 2);
    }
    public static function formatAmountForDB(string $amount): float
    {
        return (float)str_replace(["$", ","], "", $amount);
    }
    public static function defineAmountColor(string $amount): string
    {
        return strpos($amount, "-") === false ? "green" : "red";
    }
    public static function formatDateForCSV(string $date): string
    {
        return date("m/j/Y", strtotime($date));
    }
    public static function formatDateForIndex(string $date): string
    {
        return date("M j, Y", strtotime($date));
    }
    public static function formatDateForDB(string $date): string
    {
        return date("Y-m-j", strtotime($date));
    }
}
