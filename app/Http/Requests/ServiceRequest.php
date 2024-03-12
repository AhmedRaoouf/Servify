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
      'name_en' => ['required', 'string', 'max:255'],
      'name_ar' => ['required', 'string', 'max:255'],
      'description_en' => ['required', 'string'],
      'description_ar' => ['required', 'string'],
      'image' => [Rule::requiredIf(!$this->service || !$this->service->id), 'image'],
      'status' =>  Rule::in(['true', 'false']),
    ];
  }
}
