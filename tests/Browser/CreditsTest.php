<?php

use App\Models\Credit;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;

uses(DatabaseTruncation::class);
test('homepage contains empty table', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee("No credits found");
    });
});

test('homepage contains non empty table', function () {
    $credit = Credit::create([
        'amount'  => '10000',
        'recipient_id' => Recipient::factory()->create()->id,
        'term_in_months' => 12,
    ]);

    $this->browse(function (Browser $browser) use($credit) {
        $browser->visit('/')
            ->assertDontSee("No credits found")
            ->assertSeeIn('#credits-table', $credit->serial_number)
            ->assertSeeIn('#credits-table', $credit->recipient->name);
    });
});

test('paginated credits table doesnt contain 11th record', function () {
    $credits = Credit::factory(11)->create();
    $lastCredit = $credits->last();

    $this->browse(function (Browser $browser) use ($lastCredit) {
        $browser->visit('/')
            ->assertDontSeeIn('#credits-table', $lastCredit->serial_number);
    });

});
