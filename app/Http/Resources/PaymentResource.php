<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct($resource, public bool $isAmountExceeded){
        parent::__construct($resource);
        $this->isAmountExceeded = $isAmountExceeded;
    }
    public function toArray(Request $request): array
    {
        return [
            'credit_id' => $this->credit->id,
            'amount' => $this->amount,
            'is_amount_exceeded' => $this->isAmountExceeded,
        ];
    }
}