<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'address_one' => $this->address_one,
            'address_two' => $this->address_two,
            'province_id' => $this->province_id,
            'province' => $this->province ? $this->province->name : '',
            'regency_id' => $this->regency_id,
            'regency' => $this->regency ? $this->regency->name : '',
            'district_id' => $this->district_id,
            'district' => $this->district ? $this->district->name : '',
            'village_id' => $this->village_id,
            'village' => $this->village ? $this->village->name : '',
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'phone_number' => $this->phone_number,
            'store_name' => $this->store_name,
            'category' => $this->category,
            'store_status' => $this->store_status,
            'created_at' => $this->created_at
        ];
    }
}
