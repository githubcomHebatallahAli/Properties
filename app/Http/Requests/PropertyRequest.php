<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'creationDate'=> 'nullable|date_format:Y-m-d H:i:s',
            // 'broker_id' => 'nullable|exists:brokers,id',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'admin_id' => 'nullable|exists:admins,id',
            'installment_id' => 'required|exists:installments,id',
            'finishe_id' => 'required|exists:finishes,id',
            'transaction_id' => 'required|exists:transactions,id',
            'water_id' => 'required|exists:waters,id',
            'electricty_id' => 'required|exists:electricities,id',
            'governorate' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'street' => 'required|string',
            'locationGPS' => 'nullable|string',
            'facade'=> 'nullable|string',
            'propertyNum' => 'nullable|integer',
            'status'  =>'nullable|in:active,notActive',
            'sale' => 'nullable|in:sold,notSold',
            'totalPrice' =>'nullable|integer',
            'installmentPrice' =>'nullable|integer',
            'downPrice' =>'nullable|integer',
            'rentPrice' =>'nullable|integer',
            'description' =>'nullable|string',
            'area' =>'required|integer',
            'ownerType' =>'nullable|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
