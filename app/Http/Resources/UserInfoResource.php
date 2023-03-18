<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'avatar' => $this->avatar !== null ? asset('assets/images/profile/' . $this->avatar) : asset('assets/images/user.png'),
            'gender' => $this->gender,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            $this->mergeWhen($this->address, function () {
                return ["address" =>  AddressResource::collection($this->address)];
            }),
        ];
    }
}
