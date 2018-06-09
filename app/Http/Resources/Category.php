<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Category extends Resource
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
            'type'          => 'category',
            'id'            => (string)$this->id,
            'attributes'    => [
                'name' => $this->name,
                'locale' => $this->locale,
            ],            
            'links'         => [
                'self' => '',
            ],
        ];
    }
}
