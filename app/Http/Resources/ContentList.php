<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ContentList extends Resource
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
                       "title" => $this->title,                                  
                       "locale" => $this->locale,
                       "city_id" => $this->city_id,
                       "category_id" => $this->category_id,                    
                       "salary" => $this->salary,                     
                       "publish_date" => date('d M, Y',strtotime($this->publish_date)),
                       "close_date" => date('d M, Y',strtotime($this->close_date)),
                       "company" => $this->company,                      
                       "hr_id" => $this->hr_id,
             ],
            'relationships' => [
                'city' => new City($this->city($this->city_id)),
                'category' => new Category($this->category($this->category_id)),
            ],
            'links'         => [
                'self' => '',
            ],
        ];
    }
}
