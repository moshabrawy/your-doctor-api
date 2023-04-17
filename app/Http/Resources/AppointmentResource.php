<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_type = check_user_type() == 'user' ? 'doctor' : 'user';
        return [
            'id' => $this->id,
            $user_type . '_name' => $this->$user_type->name,
            'booking_day' => $this->time_slot->day_en,
            'booking_date' => $this->day_date,
            'status' => $this->status,
            'patient_name' => $this->patient_details->patient_name,
            'patient_age' => $this->patient_details->age .' years',
            'disease_dec' => $this->patient_details->disease_dec,
        ];
    }
}
