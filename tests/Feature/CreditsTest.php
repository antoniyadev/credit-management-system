<?php

use App\Models\Credit;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Collection;

use function Pest\Laravel\get;

test('created credit contains correct serial number', function () {
    $recipient = Recipient::factory()->create();
    $credit = Credit::create([
        'recipient_id'  =>$recipient->id,
        'amount' => 10000,
        'term_in_months' => 12,
    ]);

    $this->assertModelExists($recipient);
    $this->assertModelExists($credit);
    $this->assertDatabaseHas('credits', [
        'serial_number' => $credit->serial_number,
    ]);
});