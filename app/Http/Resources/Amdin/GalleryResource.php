<?php

namespace App\Http\Resources\Amdin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'image' => url(env('IMAGE_UPLOADED_FOR_PRODUCTS') . $this->path),
            'mime' => $this->mime
        ];
    }
}
