<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'name' => ['required', 'string','max:255', Rule::unique('service_descriptions')->ignore($this->service? $this->service->id : 0, 'id')],
            'description' => ['required', 'string'],
            'language_id' => ['required','exists:languages,id'],
            'service_id' => ['exists:services,id'],
            'image' => ['nullable', 'image'],
            // 'status' =>  Rule::in(['true', 'false']),
        ];
    }
}
