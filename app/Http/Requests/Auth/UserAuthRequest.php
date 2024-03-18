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
            'name' => ['required', 'string', 'min:3', 'max:250'],
            'email' => ['required','email', 'min:3', 'max:250'],
            'password' => ['required'],
            'instance_name' => ['required', 'string', 'min:3', 'max:250'],
            'pic_name' => ['required', 'string', 'min:3', 'max:250'],
            'sk_image' => ['required','array'],
            'sk_image.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
            'address' => ['required', 'min:3', 'max:250'],
            'map_coordinates' => ['required', 'min:3', 'max:250'],
            'village' => ['required', 'min:3', 'max:250'],
            'subdistrict' => ['required', 'min:3', 'max:250'],
            'city' => ['required', 'min:3', 'max:250'],
            'province' => ['required', 'min:3', 'max:250'],
            'number_telephone' => ['required','numeric','min:10'],
            'library_email' => ['required','email','min:3', 'max:250'],
        ];
    }
}
