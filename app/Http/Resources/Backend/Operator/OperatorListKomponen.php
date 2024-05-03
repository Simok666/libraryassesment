<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Backend\User\UserSubKomponenResource;
use App\Http\Resources\ImageResource;

class OperatorListKomponen extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // debug($this->pleno?->getMedia('pleno_file'));
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'pic_name' => $this->name,
            'pic_email' => $this->email,
            'status_subkomponent' => $this->status_subkomponent,
            'is_pleno' => $this->is_pleno,
            'draft_sk_upload' => ((!empty($this->pleno?->getMedia('sk_file'))) ? ImageResource::collection($this->pleno->getMedia('sk_file')) : null),
            'pleno_upload' => ((!empty($this->pleno?->getMedia('sk_file'))) ? ImageResource::collection($this->pleno->getMedia('pleno_file')) : null),
            'sk_upload_pimpinan' => ((!empty($this->pleno?->getMedia('sk_file'))) ? ImageResource::collection($this->pleno->getMedia('sk_upload_pimpinan')) : null),
            'sk_upload_pimpinan_kaban' => ((!empty($this->pleno?->getMedia('sk_file'))) ? ImageResource::collection($this->pleno->getMedia('sk_upload_pimpinan_kaban')) : null),
            'subkomponen' => UserSubKomponenResource::collection($this->komponen)
        ];
    }
}
