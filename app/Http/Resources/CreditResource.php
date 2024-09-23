<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serial_number' => $this->serial_number,
            'recipient_name' => $this->recipient?->name,
            'amount' => $this->amount,
            'term_in_months' => $this->term_in_months,
            'monthly_installment' => $this->monthly_installment,
            'remaining_balance' => $this->remaining_balance,
            'created_at' => $this->created_at?->toDateString()

        ];
    }
}