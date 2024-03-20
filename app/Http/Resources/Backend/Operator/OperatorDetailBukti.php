<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Backend\User\UserBuktiFisikDataResource;
use App\Http\Resources\Backend\User\UserBuktiFisikResource;

class OperatorDetailBukti extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bukti_fisik_data' =>  new UserBuktiFisikDataResource($this),
            'bukti_fisik' =>  UserBuktiFisikResource::collection($this->buktiFisik)
        ];
    }
}
