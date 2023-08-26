<?php

namespace App\Http\Resources;

use App\Models\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuRestaurantResource extends JsonResource
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
            'name' => $this->name,
            'cuisine_type' => $this->cuisine_type,
            'address' => $this->address,
            'contact' => $filteredContactData,
            'average_reviews' => $this->average_reviews,
            'menus' => MenuResource::collection($this->menus),


        ];
    }
}
