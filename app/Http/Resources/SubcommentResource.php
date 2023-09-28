<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcommentResource extends JsonResource
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
            "sub_commId" => $this->id,
            "sub_comment" => $this->sub_comment,
            "sub_author" => [
                "id" => $this->author->id,
                "name" =>$this->author->name
            ],
            "sub_created" => $this->created_at->format('d/m/Y')
        ];
    }
}
