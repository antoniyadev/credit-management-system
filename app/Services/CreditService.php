<?php

namespace App\Services;

use App\Models\Credit;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreditService
{
    const INTEREST_RATE = 7.9;
    const MAX_CREDIT_SUM = 80000;

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

    public function isCreditLimitReached($recipientId, $value): bool
    {
        $recipient = Recipient::find($recipientId);

        $sumAmountOfRecipientCredits = $recipient->credits()->sum('amount')/100;

        if(!$recipient) {
            throw new ModelNotFoundException("Recipient not found");
        }

        if($sumAmountOfRecipientCredits + $value > self::MAX_CREDIT_SUM) {
            return true;
        }
        return false;
    }

    public function isAmountExceeded($remainingBalance, $amount): bool
    {
        // Check if the payment amount exceeds the remaining balance:
        return $amount > $remainingBalance ? true : false;

    }
}