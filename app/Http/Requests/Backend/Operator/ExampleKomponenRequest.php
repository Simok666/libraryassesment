<?php

namespace App\Http\Requests\Backend\Operator;

use Illuminate\Foundation\Http\FormRequest;

class ExampleKomponenRequest extends FormRequest
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
            'example' =>  ['required', 'array'] ,
            'example.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048']
        ];
    }
}
