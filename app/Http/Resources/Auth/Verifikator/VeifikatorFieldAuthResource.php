<?php

namespace App\Http\Resources\Auth\Verifikator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeifikatorFieldAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'verifikator_field_name' => $this->name,
            'verifikator_field_email' => $this->email,
            'token' => $this->createToken('mobile', ['role:verifikator_field'])->plainTextToken
        ];
    }
}
