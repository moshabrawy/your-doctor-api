<?php

namespace App\Http\Resources;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeSlotResource extends JsonResource
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
            'clinic_address' => $this->address,
            'slots' => collect($this->time_slots)->map(function ($slot) {
                $array = [
                    'id' => $slot['id'],
                    'day' => $slot['day_en'],
                    'start_time' => Carbon::parse($slot['start_time'])->format('h:i A'),
                    'end_time' => Carbon::parse($slot['end_time'])->format('h:i A')
                ];
                return $array;
            }),

        ];
    }
}
