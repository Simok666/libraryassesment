<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserKomponenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title_komponens' => $this->title_komponens,
            'jumlah_indikator_kunci' => $this->jumlah_indikator_kunci,
            'bobot' => $this->bobot,
            'jenis_perpustakaan' => $this->jenis_perpustakaan
        ];
    }
}
