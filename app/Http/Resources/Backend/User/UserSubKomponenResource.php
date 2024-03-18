<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;

class UserSubKomponenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'subkomponen_id' => $this->subkomponen_id,
            'skor_subkomponen' => $this->skor_subkomponen,
            'nilai' => $this->nilai,
            'is_verified' => $this->is_verified,
            'bukti_dukung' => ImageResource::collection($this->getMedia('images')),
        ];
    }
}
