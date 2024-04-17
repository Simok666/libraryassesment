<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;

class UserBuktiFisikResource extends JsonResource
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
            'user_id' => $this->user_id,
            'bukti_fisik_data_id' => $this->bukti_fisik_data_id,
            'status' => $this->status,
            'status_verifikasi' => $this->status_verifikator,
            'notes' => $this->notes,
            'bukti_fisik_upload' => ImageResource::collection($this->getMedia('images')),
            'bukti_fisik_data' => $this->buktiFisikData ?? []
        ];
    }
}
