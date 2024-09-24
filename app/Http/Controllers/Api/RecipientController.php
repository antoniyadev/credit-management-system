<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipientRequest;
use App\Http\Resources\RecipientResource;
use App\Models\Recipient;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function index(){
        return RecipientResource::collection(Recipient::all());
    }

    public function store(StoreRecipientRequest $request){
        $recipient = Recipient::create($request->all());
        return new RecipientResource($recipient);
    }
}