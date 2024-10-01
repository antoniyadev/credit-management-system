<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipientRequest;
use App\Http\Resources\RecipientResource;
use App\Models\Recipient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipientController extends Controller
{
    public function index()
    {
        return RecipientResource::collection(Recipient::all());
    }

    public function store(StoreRecipientRequest $request)
    {
        try {
            $recipient = Recipient::create($request->all());

            Log::info('Recipient created: ' . $recipient->id);

            return new RecipientResource($recipient);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
