<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class City extends Resource
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
            'type'          => 'city',
            'id'            => (string)$this->id,
            'attributes'    => [
                'name' => str_replace(['province','city'], '', strtolower($this->name)),
                'locale' => $this->locale,
            ],
            'links'         => [
                'self' => '',
            ],
        ];
    }
}
