<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required','email',Rule::unique('users')->ignore($this->admin? $this->admin->id : 0, 'id')],
            'phone' => ['nullable', 'numeric'],
            'image' =>  ['nullable','image']
        ];
        if ($this->filled('password') && isset($this->admin)) {
            $rules['password'] = ['sometimes', 'min:8'];
        }
        elseif (!isset($this->admin)) {
            $rules['password'] = ['required', 'min:8'];
        }
        if ($this->image && isset($this->admin)) {
            $rules['image'] = ['sometimes', 'image'];
        }
        elseif (!isset($this->admin)) {
            $rules['image'] = ['required', 'image'];
        }
        return  $rules ;
    }
}
