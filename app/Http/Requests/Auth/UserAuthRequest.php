<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class UserAuthRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required','email', 'min:3', 'max:20'],
            'password' => ['required'],
            'instance_name' => ['required', 'string', 'min:3', 'max:20'],
            'pic_name' => ['required', 'string', 'min:3', 'max:20'],
            'address' => ['required', 'min:3', 'max:20'],
            'map_coordinates' => ['required', 'min:3', 'max:20'],
            'village' => ['required', 'min:3', 'max:20'],
            'subdistrict' => ['required', 'min:3', 'max:20'],
            'city' => ['required', 'min:3', 'max:20'],
            'province' => ['required', 'min:3', 'max:20'],
            'number_telephone' => ['required','numeric','min:10'],
            'library_email' => ['required','email','min:3', 'max:20']
        ];
    }
}
