<?php

use App\Models\Credit;
use App\Models\Recipient;
use App\Services\CreditService;

test('calculate monthly installment successful', function () {
    $monthlyInstallment = (new CreditService())->calculateMonthlyInstallment(1000000, 12);

    expect($monthlyInstallment)
        ->toBeFloat()
        ->toEqual(869.42);
});

test('created credit contains correct serial number', function () {
    $recipient = Recipient::factory()->create();

    $credit1 = Credit::create([
        'recipient_id'  =>$recipient->id,
        'amount' => 10000,
        'term_in_months' => 12,
    ]);
    $credit2 = Credit::create([
        'recipient_id'  =>$recipient->id,
        'amount' => 10000,
        'term_in_months' => 12,
    ]);
    $credit3 = Credit::create([
        'recipient_id'  =>$recipient->id,
        'amount' => 10000,
        'term_in_months' => 12,
        'created_at' => now()->addMonths(-3),
    ]);

    (new CreditService())->generateSerialNumber($credit1);
    expect((new CreditService())->generateSerialNumber($credit1))
        ->toBe($credit1->created_at->format('Y-m') . '-0000001');
    expect((new CreditService())->generateSerialNumber($credit2))
        ->toBe($credit2->created_at->format('Y-m') . '-0000002');
    expect((new CreditService())->generateSerialNumber($credit3))
        ->toBe($credit3->created_at->format('Y-m') . '-0000001');
});