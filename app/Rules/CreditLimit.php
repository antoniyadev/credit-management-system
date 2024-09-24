<?php

namespace App\Rules;

use App\Models\Recipient;
use App\Services\CreditService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditLimit implements ValidationRule
{
    private $recipientId;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct($recipientId) {
       $this->recipientId = $recipientId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if((new CreditService())->isCreditLimitReached($this->recipientId, $value)) {
            $fail("The recipient's credit limit has been reached.");
        }
    }
}