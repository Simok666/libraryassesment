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
            'pic_name' => $this->name,
            'pic_email' => $this->email,
            'BuktiFisik' => UserBuktiFisikResource::collection($this->buktiFisik)
        ];
    }
}
