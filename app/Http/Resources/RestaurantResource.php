<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $filteredContactData = json_decode( $this->contact, true);
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'cuisine_type' => $this->cuisine_type,
            'address' => $this->address,
            'contact' => $filteredContactData,
            'average_reviews' => $this->average_reviews,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];

    }
}
