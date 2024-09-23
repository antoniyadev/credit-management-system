<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreditRequest;
use App\Http\Resources\CreditResource;
use App\Models\Credit;
use App\Services\CreditService;

class CreditController extends Controller
{
    public function index()
    {
        $orderColumn = request('order_column', 'created_at');
        if (! in_array($orderColumn, ['id', 'recipient_name', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (! in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }

        $credits = Credit::select('credits.*', 'r.name as recipient_name')
            ->join('recipients as r', 'credits.recipient_id', '=', 'r.id')
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(10);

        return CreditResource::collection($credits);
    }

    public function fetchAllForPayment() {
        $creditsForPayment = Credit::all()->where('remaining_balance', '>', 0);
        return CreditResource::collection($creditsForPayment);
    }

    public function store(StoreCreditRequest $request): CreditResource {
        // create a new credit
        $credit = Credit::create($request->validated());
        // return the created credit
        return new CreditResource($credit);
    }

    public function show(Credit $credit)
    {
        return new CreditResource($credit);
    }
}