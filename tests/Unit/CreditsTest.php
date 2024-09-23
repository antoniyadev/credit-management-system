<?php

use App\Services\CreditService;

test('calculate monthly installment successful', function () {
    $monthlyInstallment = (new CreditService())->calculateMonthlyInstallment(1000000, 12);

    expect($monthlyInstallment)
        ->toBeFloat()
        ->toEqual(869.42);
});