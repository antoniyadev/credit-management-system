<?php

namespace App\Services;

use App\Models\Credit;

class CreditService
{
    const INTEREST_RATE = 7.9;

    public function generateSerialNumber(Credit $credit): string
    {
        if($credit->serial_number) {
            return $credit->serial_number;
        }
        $credit->serial_series = $credit->created_at->format('Y-m');

        $credit->number = (Credit::where('serial_series', $credit->serial_series)->max('number') ?? 0) + 1;

        $credit->serial_number = $credit->serial_series . '-' .str_pad($credit->number, 7, '0', STR_PAD_LEFT);

        $credit->save();

        return $credit->serial_number;
    }

    public function calculateMonthlyInstallment($amount, $termInMonths): float
    {
        //Calculate the monthly interest rate (r):
        $r = (self::INTEREST_RATE / 12) / 100;

        //Calculate the monthly installment:
        $monthlyInstallment = $amount / 100 * ($r * pow((1 + $r), $termInMonths)) / (pow((1 + $r), $termInMonths) - 1);

        return round($monthlyInstallment, 2);
    }
}