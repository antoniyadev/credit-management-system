<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Credit;
use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request): PaymentResource {
        $data = $request->validated();
        $credit = Credit::find($data['credit_id']);

        if(!$credit) {
            throw new ModelNotFoundException('Credit not found');
        }

        // Check if the payment amount exceeds the remaining balance:
        $isAmountExceeded = false;
        $remainingBalance = $credit->remaining_balance;
        $amount = $data['amount'];

        // If payment amount exceeds the remaining balance, adjust the payment amount to the remaining balance.
        if($amount > $remainingBalance) {
            $amount = $remainingBalance;
            $isAmountExceeded = true;
        }
        // If no, proceed with the full payment.
        $payment = Payment::create([
            'credit_id' => $data['credit_id'],
            'amount' => $amount
        ]);

        return new PaymentResource($payment, $isAmountExceeded);
    }
}
