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
        $endpoint = $request->segment(2); // Endpoint Name
        return [
            $this->mergeWhen($endpoint != 'get_doctors_by_specialty' && $endpoint != 'search', function () {
                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'avatar' => $this->avatar != null ? asset('uploads/images/profile/' . $this->avatar) : ($this->gender == 'male' ? 'https://i.ibb.co/5cPD8dP/doctors-man.jpg' : 'https://i.ibb.co/J5vKKQt/doctors-women.jpg'),
                    // 'avatar' => $this->gender == 'male' ? 'https://i.ibb.co/5cPD8dP/doctors-man.jpg' : 'https://i.ibb.co/J5vKKQt/doctors-women.jpg',
                    'specialty' => $this->doctor_info->specialty->title,
                ];
            }),
            $this->mergeWhen($endpoint == 'get_doctors_by_specialty' || $endpoint == 'search', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'avatar' => $this->user->avatar != null ? $this->user->avatar : ($this->user->gender == 'male' ? 'https://i.ibb.co/5cPD8dP/doctors-man.jpg' : 'https://i.ibb.co/J5vKKQt/doctors-women.jpg'),
                    'specialty' => $this->specialty->title,
                ];
            }),
            $this->mergeWhen($request->details == true, function () {
                return [
                    'bio' => $this->doctor_info->bio,
                    'phone' => $this->phone,
                    'fees' => $this->doctor_info->fees,
                    'addresses' => TimeSlotResource::collection($this->address)
                ];
            })
        ];
    }
}
