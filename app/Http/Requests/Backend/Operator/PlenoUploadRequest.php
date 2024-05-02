<?php

namespace App\Http\Requests\Backend\Operator;

use Illuminate\Foundation\Http\FormRequest;

class PlenoUploadRequest extends FormRequest
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
            'draft_sk_upload' => (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinan' || auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinankaban') ? ['array'] : ['required','array'],
            'draft_sk_upload.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
            'pleno_upload' => (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinan' || auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinankaban') ? ['array'] : ['required','array'],
            'pleno_upload.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
            'sk_upload_pimpinan' => (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinan' ) ? ['required', 'array'] : ['array'],
            'sk_upload_pimpinan.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
            'sk_upload_pimpinan_kaban' => (auth()->user()->currentAccessToken()->getAttributeValue('abilities')[0] == 'role:pimpinankaban') ? ['required', 'array'] : ['array'],
            'sk_upload_pimpinan_kaban.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048']
        ];
    }
}
