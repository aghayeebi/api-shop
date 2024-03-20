<?php

namespace App\Http\Resources;

use App\Http\Resources\Amdin\GalleryResource;
use App\Models\Gallery;
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
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
//           'slug'=> $this->slug,
            'image' => url(env('IMAGE_UPLOADED_FOR_PRODUCTS') . $this->image),
            'price'=> $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'galleries' => GalleryResource::collection($this->galleries),
        ];
    }
}
