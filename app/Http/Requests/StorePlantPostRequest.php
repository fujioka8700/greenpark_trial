<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantPostRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => 'required|string|unique:plants|max:50',
      'file' => 'required|file|image|max:1000',
      'description' => 'required|string|max:1000',
      'places' => 'required|string',
      'colors' => 'nullable|string',
    ];
  }
}
