<?php

namespace App\Http\Requests\Auth;

use App\Rules\LoginExistsInTablesRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneNumberExistsInTablesRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
            // 'phoNum' => ['required','phoNum',new PhoneNumberExistsInTablesRule()],
            'otp' =>['required','max:4'],
            'password' =>['required','min:6'],
    //         'login' => [
    // 'required',
    // 'string',
    // function ($attribute, $value, $fail) {
    //     if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^\+?[0-9]{10,15}$/', $value)) {
    //         $fail('The login must be a valid email or phone number.');
    //     }
    // },
// ],

'login' => ['required', new LoginExistsInTablesRule()],
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
