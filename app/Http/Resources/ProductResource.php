<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'weight' => $this->weight,
            'stock' => $this->stock,
            'price' => $this->price,
            'description' => $this->description,
            'category' => $this->category,
            'user' => new UserResource($this->user),
            'photos' => $this->productGaleries,
            'created_at' => $this->created_at
        ];
    }
}
