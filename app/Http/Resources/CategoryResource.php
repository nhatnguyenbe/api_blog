<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "cate_id" => $this->id,
            "cate_title" => $this->title,
            "cate_slug" => $this->slug,
            "cate_descrip" => $this->description,
            "cate_created" => $this->created_at->format("d-m-Y")
        ];
    }
}
