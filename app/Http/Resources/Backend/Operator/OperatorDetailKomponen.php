<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Backend\User\UserKomponenResource;
use App\Http\Resources\Backend\User\UserSubKomponenResource;


class OperatorDetailKomponen extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'sub_komponen' =>  new UserKomponenResource($this),
            'komponen' =>  UserSubKomponenResource::collection($this->subKomponens)
        ];
    }
}
