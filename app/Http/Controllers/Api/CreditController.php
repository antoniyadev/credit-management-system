<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexCreditRequest;
use App\Http\Requests\StoreCreditRequest;
use App\Http\Resources\CreditResource;
use App\Models\Credit;
use Exception;
use Illuminate\Support\Facades\Log;

class CreditController extends Controller
{
    public function index(IndexCreditRequest $request)
    {
        $orderColumn = $request->query('order_column', 'created_at');
        $orderDirection = $request->query('order_direction', 'desc');

        $credits = Credit::select('credits.*', 'r.name as recipient_name')
            ->join('recipients as r', 'credits.recipient_id', '=', 'r.id')
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(10);

        return CreditResource::collection($credits);
    }

    public function fetchAllForPayment()
    {
        $creditsForPayment = Credit::all()->where('remaining_balance', '>', 0);
        return CreditResource::collection($creditsForPayment);
    }

    public function store(StoreCreditRequest $request): ?CreditResource
    {
        try {
            // create a new credit
            $credit = Credit::create($request->validated());
            Log::info('Credit created: ' . $credit->id);
            // return the created credit
            return new CreditResource($credit);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function show(Credit $credit)
    {
        return new CreditResource($credit);
    }
}
