<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Credit;
use App\Models\Payment;
use App\Services\CreditService;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request): PaymentResource
    {
        try {
            $data = $request->validated();
            $credit = Credit::findOrFail($data['credit_id']);

            $remainingBalance = $credit->remainingBalance;
            $isAmountExceeded = (new CreditService())->isAmountExceeded($remainingBalance, $data['amount']);

            // If payment amount exceeds the remaining balance, adjust the payment amount to the remaining balance.
            $amount = $isAmountExceeded ? $remainingBalance : $data['amount'];

            $payment = Payment::create([
                'credit_id' => $data['credit_id'],
                'amount' => $amount,
            ]);
            Log::info('Payment created: ' . $payment->id);
            return new PaymentResource($payment, $isAmountExceeded);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
