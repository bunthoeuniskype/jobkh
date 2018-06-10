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
                        "title" => $this->title,
                       "title_compare" => $this->title_compare,
                       "description" => $this->description,                  
                       "locale" => $this->locale,
                       "city_id" => $this->city_id,
                       "category_id" => $this->category_id,
                       "job_requirement" => $this->job_requirement,
                       "experience" => $this->experience,
                       "level" => $this->level,
                       "hiring" => $this->hiring,
                       "salary" => $this->salary,
                       "sex" => $this->sex,
                       "age" => $this->age,
                       "term" => $this->term,
                       "function" => $this->function,
                       "industry" => $this->industry,
                       "qualification" => $this->qualification,
                       "language" => $this->language,
                       "location" => $this->location,
                       "publish_date" => date('d M, Y',strtotime($this->publish_date)),
                       "close_date" => date('d M, Y',strtotime($this->close_date)),
                       "company" => $this->company,
                       "contact" => $this->contact,
                       "phone" => $this->phone,
                       "email" => $this->email,
                       "website" => $this->website,
                       "address" => $this->address,
                       "type" => $this->type,
                       "employee" => $this->employee,
                       "company_profile" => $this->company_profile,
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
