<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MediaRequest extends FormRequest
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
            'property_id' => 'nullable|exists:properties,id',
            'mainImage' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'video' => 'nullable|file|mimes:mp4,mov,avi,mkv,flv,wmv,webm,3gp',
            // 'audio' => 'nullable|file|mimes:mp3,wav,aac,ogg,flac,m4a',
            'audio' => 'nullable|file|extensions:m4a,mp3,wav,aac,ogg,flac',
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
