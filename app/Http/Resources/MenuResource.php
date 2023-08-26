<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


        public function toArray($request)
        {
            $item=$this->item;
            return [
                'uuid' => $this->uuid,
                'price' => $this->price,
                'item'=> new ItemResource($item)
            ];
        }

    }

