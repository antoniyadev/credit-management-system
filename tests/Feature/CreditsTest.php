<?php

use App\Models\Credit;
use App\Models\Recipient;
use App\Services\CreditService;

use function Pest\Laravel\postJson;

test('created credit successful', function () {
    $recipient = Recipient::factory()->create();
    $credit = Credit::create([
        'recipient_id'  =>$recipient->id,
        'amount' => 10000,
        'term_in_months' => 12,
    ]);

    postJson('/api/credits', $credit->toArray())
        ->assertStatus(201);

    $this->assertModelExists($recipient);
    $this->assertModelExists($credit);
    $this->assertDatabaseHas('credits', [
        'serial_number' => $credit->serial_number,
    ]);
});

test('credit limit cannot be more then limit', function () {
    $recipient = Recipient::factory()->create();
    $credit = [
        'recipient_id'  =>$recipient->id,
        'amount' => CreditService::MAX_CREDIT_SUM + 1,
        'term_in_months' => 12,
    ];

    postJson('/api/credits', $credit)->assertStatus(422);
});