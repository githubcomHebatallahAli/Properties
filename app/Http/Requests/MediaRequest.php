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

            'media.*.file' => [
                'nullable',
                'file',
                'max:10240', // الحجم الأقصى 10 ميجابايت
                function ($attribute, $value, $fail) {
                    $allowedExtensions = [
                        'audio' => ['mp3', 'wav', 'aac', 'ogg', 'flac', 'm4a'],
                        'image' => ['jpeg', 'png', 'jpg', 'gif', 'webp', 'bmp', 'svg'],
                        'video' => ['mp4', 'mov', 'avi', 'mkv', 'flv', 'wmv', 'webm', '3gp'],
                    ];

                    $extension = $value->getClientOriginalExtension();
                    $type = request()->input(str_replace('.file', '.type', $attribute));

                    if (!array_key_exists($type, $allowedExtensions)) {
                        $fail("نوع الميديا غير مدعوم.");
                        return;
                    }

                    if (!in_array($extension, $allowedExtensions[$type])) {
                        $fail("يجب أن يكون الملف من الأنواع التالية لـ $type: " . implode(', ', $allowedExtensions[$type]) . ".");
                    }
                },
            ],
            'media.*.type' => 'required|in:image,video,audio',
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
