<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Content extends Resource
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
            'type'          => 'content',
            'id'            => (string)$this->id,
            'attributes'    => [
                'title' => $this->title,
                'locale' => $this->locale,
            ],
            //'relationships' => new ArticleRelationshipResource($this),
            'links'         => [
                'self' => '',
            ],
        ];
    }
}
