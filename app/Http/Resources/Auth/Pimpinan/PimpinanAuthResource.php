<?php

namespace App\Http\Resources\Auth\Pimpinan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PimpinanAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pimpinan_name' => $this->name,
            'pimpinan_email' => $this->email,
            'token' => $this->createToken('mobile', ['role:pimpinan'])->plainTextToken
        ];
    }
}
