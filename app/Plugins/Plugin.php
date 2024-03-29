<?php

namespace App\Plugins;

use Carbon\Carbon;

class Plugin
{
    public static function saveImage($request, $dir): string
    {
        $imagePath = Carbon::now()->microsecond . '.' . $request->image->extension();
        $request->image->storeAs('images/' . $dir, $imagePath, 'public');
        return $imagePath;
    }


}
