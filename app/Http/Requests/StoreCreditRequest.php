<?php

namespace App\Http\Requests;

use App\Rules\CreditLimit;
use Illuminate\Foundation\Http\FormRequest;

class StoreCreditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return ['recipient_id' => 'recipient'];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipient_id' => ['required',  'exists:recipients,id'],
            'amount' => ['required', 'numeric', new CreditLimit($this->recipient_id)],
            'term_in_months' => ['required', 'numeric', 'min:3', 'max:120'],
        ];
    }
}