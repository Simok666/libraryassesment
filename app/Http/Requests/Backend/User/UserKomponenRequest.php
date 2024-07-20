<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class UserKomponenRequest extends FormRequest
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
            // 'user_id' => ['required', 'numeric'],
            '*.subkomponen_id' => ['required', 'numeric'],
            '*.skor_subkomponen' => ['required', 'numeric'],
            '*.nilai' => ['required', 'numeric'],
            // '*.is_verified' => ['required', 'boolean'],
            '*.bukti_dukung' => ['mimes:jpg,png,jpeg,gif,svg,pdf', 'max:2048'],
            // '*.bukti_dukung' => ['required', 'array'],
            // '*.bukti_dukung' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
        ];
    }
}
