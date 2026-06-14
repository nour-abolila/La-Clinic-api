<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $doctor = auth()->check() && auth()->id() === $this->user_id;

        return [
            'id' => $this->id,
            'name' => $this->user->first_name . ' ' . $this->user->last_name,
            'specialization' => $this->specialization,
            'session_price' => $this->session_price,
            'rating' => $this->rating ?? null,
            'created_at' => $this->created_at,
            'email' => $doctor ? $this->user->email : null,
            'phone_number' => $doctor ? $this->user->phone_number : null,
            'working_days' => $doctor ? $this->working_days : null,
            'start_time' => $doctor ? $this->start_time : null,
            'end_time' => $doctor ? $this->end_time : null,
            'bio' => $doctor ? $this->bio : null,
        ];
    }
}
