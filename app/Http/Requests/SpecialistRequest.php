<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SpecialistRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'average_rating' => 'nullable|numeric|min:0|max:5',
            'description' => 'required|string',
            'num_of_experience' => 'nullable|integer|min:0',
            'num_of_customers' => 'nullable|integer|min:0',
            'earning' => 'nullable|integer|min:0',
            'personal_card' => 'nullable',
            'personal_card.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'personal_image' => 'nullable|image',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "status" => false,
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
