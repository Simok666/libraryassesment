<?php

namespace App\Http\Resources\Auth\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
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
            'customer_email' => $this->email,
            'token' => $this->createToken('mobile', ['role:user'])->plainTextToken
        ];
    }
}
