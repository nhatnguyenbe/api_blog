<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            "comm_id"=> $this->id,
            "comment" => $this->comment,
            "post_id" => $this->post->id,
            "subComment" => SubcommentResource::collection($this->subComment),
            "author" => [
                "id" => $this->author->id,
                "name" =>$this->author->name
            ],
            "comm_created" => $this->created_at->format('d/m/Y')
        ];
    }
}
