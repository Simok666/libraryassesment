<?php

namespace App\Http\Resources\Backend\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'instance_name' => $this->instance_name,
            'pic_name' => $this->pic_name,
            'leader_instance_name' => $this->leader_instance_name,
            'library_name' => $this->library_name,
            'head_library_name' => $this->head_library_name,
            'npp' => $this->npp,
            'address' => $this->address,
            'map_coordinates' => $this->map_coordinates,
            'village' => $this->village,
            'subdistrict' => $this->subdistrict,
            'city' => $this->city,
            'province' => $this->province,
            'number_telephone' => $this->number_telephone,
            'website' => $this->website,
            'library_email' => $this->library_email,
            'is_verified' => $this->is_verified,
        ];
    }
}
