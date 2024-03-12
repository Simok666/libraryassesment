<?php

namespace App\Http\Resources\Auth\Operator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatorAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'operator_name' => $this->name,
            'operator_email' => $this->email,
            'token' => $this->createToken('mobile', ['role:operator'])->plainTextToken
        ];
    }
}
