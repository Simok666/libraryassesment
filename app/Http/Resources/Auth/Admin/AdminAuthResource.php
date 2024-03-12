<?php

namespace App\Http\Resources\Auth\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'admin_name' => $this->name,
            'admin_email' => $this->email,
            'token' => $this->createToken('mobile', ['role:admin'])->plainTextToken
        ];
    }
}
