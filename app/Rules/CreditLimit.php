<?php

namespace App\Rules;

use App\Models\Recipient;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditLimit implements ValidationRule
{
    private $recipient;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct($recipientId) {
        $recipient = Recipient::find($recipientId);
        $this->recipient = $recipient;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->recipient) {
            $fail("The recipient does not exist. Cannot check the credit limit.");
        }

        $sumAmountOfRecipientCredits = $this->recipient->credits()->sum('amount')/100;
        if($sumAmountOfRecipientCredits + $value > 80000) {
            $fail("The recipient's credit limit has been reached.");
        }
    }
}