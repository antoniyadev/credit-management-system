<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Credit;
use App\Models\Payment;
use App\Services\CreditService;
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
        $remainingBalance = $credit->remainingBalance;
        $isAmountExceeded = (new CreditService())->isAmountExceeded($remainingBalance, $data['amount']);

        // If payment amount exceeds the remaining balance, adjust the payment amount to the remaining balance.
        $amount = $isAmountExceeded ? $remainingBalance : $data['amount'];

        $payment = Payment::create([
            'credit_id' => $data['credit_id'],
            'amount' => $amount,
        ]);

        return new PaymentResource($payment, $isAmountExceeded);
    }
}