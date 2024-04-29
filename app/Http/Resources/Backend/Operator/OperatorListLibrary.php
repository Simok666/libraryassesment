<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Backend\User\UserResource;

class OperatorListLibrary extends JsonResource
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
            'pic_name' => $this->name,
            'pic_email' => $this->email,
            'status_perpustakaan' => $this->status_perpustakaan,
            'status_subkomponent' => $this->status_subkomponent,
            'status_buktifisik' => $this->status_buktifisik,
            'is_pleno' => $this->is_pleno,
            'profil_perpustakaan' => new UserResource($this->library)
        ];
    }
}
