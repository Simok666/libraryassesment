<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nomor_npp' =>  ['required','max:100'],
            'hasil_akreditasi' => ['required', 'string' ,'max:100'],
            'nama_perpustakaan' => ['required', 'string' ,'max:100'],
            'alamat' => ['required', 'string' ,'max:100'],
            'desa' => ['required', 'string' ,'max:100'],
            'kabupaten_kota' => ['required', 'string' ,'max:100'],
            'provinsi' => ['required', 'string' ,'max:100'],
            'no_telp' => ['required', 'string' ,'max:100'],
            'situs_web' => ['required', 'string' ,'max:100'],
            'email' => ['required','email','string' ,'max:100'],
            'status_kelembagaan' => ['required', 'string' ,'max:100'],
            'tahun_berdiri_perpustakaan' => ['required', 'string' ,'max:100'],
            'sk_pendirian_perpustakaan' => ['required', 'string' ,'max:100'],
            'nama_kepala_perpustakaan' => ['required', 'string' ,'max:100'],
            'nama_kepala_instansi' => ['required', 'string' ,'max:100'],
            'induk' => ['required', 'string' ,'max:100'],
            'visi' => ['required', 'string' ,'max:100'],
            'misi' => ['required', 'string' ,'max:100'],
            'data_perpustakaan_image' => ['required','array'],
            'data_perpustakaan_image.*' => ['mimes:jpg,png,jpeg,gif,svg,pdf','max:2048'],
        ];
    }
}
