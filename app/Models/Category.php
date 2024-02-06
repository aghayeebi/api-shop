<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function newCategory($request): void
    {
        $this->query()->create([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);
    }

    public function updateCategory($request): void
    {

        $this->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);

    }
}
