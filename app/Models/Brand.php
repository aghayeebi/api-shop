<?php

namespace App\Models;

use App\Plugins\Plugin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;


/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BrandFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withoutTrashed()
 * @mixin \Eloquent
 */
class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'brands';

    protected string $path = 'brand';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function newBrand($request): void
    {
        self::query()->create([
            'title' => $request->title,
            'image' => Plugin::saveImage($request, 'brands')
        ]);
    }

    public function updateBrand($request): void
    {
        if ($request->has('image')) {
            Plugin::saveImage($request, 'brands');
        }
        $this->update([
            'title' => $request->title,
            'image' => $request->has('image') ? $request->image : $this->image
        ]);
    }

}
