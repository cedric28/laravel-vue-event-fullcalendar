<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->event_name,
            'rrule' => [
                'dtstart'   =>  $this->start_date,
                'byweekday' => unserialize($this->week_day),
                'until'     => $this->end_date
            ],
      
        ];
    }
}
