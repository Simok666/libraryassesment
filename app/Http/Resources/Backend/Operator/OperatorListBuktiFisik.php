<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Backend\User\UserBuktiFisikResource;

class OperatorListBuktiFisik extends JsonResource
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
            'status_buktifisik' => $this->status_buktifisik,
            'BuktiFisik' => UserBuktiFisikResource::collection($this->buktiFisik)
        ];
    }
}
