<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function newBrand($request): void
    {
        $this->query()->create([
            'title' => $request->title,
            'image' => $this->saveImage($request)
        ]);
    }

    public function updateBrand($request): void
    {
        if ($request->has('image')) {
            $this->saveImage($request);
        }
        $this->update([
            'title' => $request->title,
            'image' => $request->has('image') ? $request->image : $this->image
        ]);
    }

    public function saveImage($request): string
    {
        $imagePath = Carbon::now()->microsecond . '.' . $request->image->extension();
        $request->image->storeAs('image/brands', $imagePath, 'public');
        return $imagePath;
    }
}
