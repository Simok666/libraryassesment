<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class UserBuktiFisikRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'bukti_fisik_data_id' => ['required', 'numeric'],
            'bukti_fisik_upload' => ['required', 'array'],
            'bukti_fisik_upload.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
        ];
    }
}
