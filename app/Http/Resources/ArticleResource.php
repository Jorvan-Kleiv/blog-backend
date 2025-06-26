<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'is_liked' =>$this->is_liked,
            'likes_count' => $this->likes_count,
            'created_at' => $this->created_at->format("Y-m-d    H:i:s"),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'owner' => UserResource::make($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
