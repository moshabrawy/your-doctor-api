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
            'specialty' => $this->doctor_info->specialty->title,
            $this->mergeWhen($request->details == true, function () {
                return [
                    'bio' => $this->doctor_info->bio,
                    'phone' => $this->phone,
                    'fees' => $this->doctor_info->fees,
                    'slots' => TimeSlotResource::collection($this->time_slot)
                ];
            })
        ];
    }
}
