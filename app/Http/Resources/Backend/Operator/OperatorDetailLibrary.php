<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatorDetailLibrary extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nomor_npp" => $this->nomor_npp,
            "hasil_akreditasi" => $this->hasil_akreditasi,
            "nama_perpustakaan" => $this->nama_perpustakaan,
            "alamat" => $this->alamat,
            "desa" => $this->desa,
            "kabupaten_kota" => $this->kabupaten_kota,
            "provinsi" => $this->provinsi,
            "no_telp" => $this->no_telp,
            "situs_web" => $this->situs_web,
            "email" => $this->email,
            "status_kelembagaan" => $this->status_kelembagaan,
            "tahun_berdiri_perpustakaan" => $this->tahun_berdiri_perpustakaan,
            "sk_pendirian_perpustakaan" => $this->sk_pendirian_perpustakaan,
            "nama_kepala_perpustakaan" => $this->nama_kepala_perpustakaan,
            "nama_kepala_instansi" => $this->nama_kepala_instansi,
            "induk" => $this->induk,
            "jenis_perpustakaan" => $this->jenis_perpustakaan,
            "visi" => $this->visi,
            "misi" => $this->misi,
            "status" => $this->status
        ];
    }
}
