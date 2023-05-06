<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'full_name' => $this->name,
            "first_name" => explode(" ", $this->name)[0],
            "last_name" => explode(" ", $this->name, 2)[1] ?? '',
            'email' => $this->email,
            'user_type' => $this->user_type === 0 ? 'Doctor' : 'User',
            'avatar' => $this->avatar,
            // 'avatar' => $this->avatar !=  null ? 'https://i.ibb.co/ykGqBLZ/641db8f79c465.jpg' : 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
            'gender' => $this->gender,
            'phone' => $this->phone,
            'birth_date' => Carbon::parse($this->birth_date)->format('d, M, Y'),
            $this->mergeWhen($this->address, function () {
                return ["addresses" =>  AddressResource::collection($this->address)];
            }),
        ];
    }
}
