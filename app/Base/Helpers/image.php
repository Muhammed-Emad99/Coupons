<?php

namespace App\Base\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


class Image
{
    public static function getImage($path, $image)
    {
        return asset($path . $image);
    }

    public static function uploadImage(UploadedFile $image, $name, $path = 'uploads/')
    {
        if ($image) {
            $imageName = $name . "-" . Str::random(5) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);
            return $imageName;
        }

        return null;
    }


}
