<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id ?? '',
            'name'        => $this->name ?? '',
            'email'       => $this->email ?? '',
            'provider'    => $this->provider ?? '',
            'provider_id' => $this->provider_id ?? '',
            'role'        => $this->role ?? '',
            'status'      => $this->status ?? '',
            'user_type'   => $this->user_type ?? '',
            'avatar'      => $this->avatar ?? '',
            'phone'       => $this->phone ?? '',
            'created_at'  => $this->created_at ? $this->created_at->toDateTimeString() : '',
            'updated_at'  => $this->updated_at ? $this->updated_at->toDateTimeString() : '',
        ];
    }
}
