<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
        $rules =  [
            'name' => ['required', 'string','min:5', 'max:255', 'regex:/^[A-Za-z0-9_ ]+$/',],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string','confirmed', 'min:8', 'max:50'],
            'image' => ['nullable', 'image', 'max:5120'],
            'phone' => ['nullable', 'string', 'regex:/^(?:\+20)?(?:01[0-5])[0-9]{8}$/'],
            'country_id' => ['nullable', 'string', 'exists:countries,id'],
            'governorate_id' => ['nullable', 'string', 'exists:governorates,id'],
            'birthday' => ['nullable', 'date', 'before:today'],
        ];
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "status" => false,
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
