<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            "post_id" => $this->id,
            "post_title" => $this->title,
            "post_slug" => $this->slug,
            "post_thumbnail" => $this->thumbnail,
            "post_summary" => $this->summary,
            "post_content" => $this->content,
            "userId" => $this->user_id,
            "categoryId" => $this->category_id,
            "created_at" => $this->created_at->format('d/m/Y')
        ];
    }
}
