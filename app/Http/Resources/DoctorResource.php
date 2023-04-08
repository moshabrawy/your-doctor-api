<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'avatar' => $this->avatar,
            $this->mergeWhen($request->details == true, function () {
                return [
                    'bio' => $this->doctor_info->bio,
                    'phone' => $this->phone,
                    'specialty' => $this->doctor_info->specialty->title,
                    'fees' => $this->doctor_info->fees
                ];
            })
        ];
    }
}