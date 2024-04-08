<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait MediaTrait
{
    public static function upload($image, string $dir): string
    {
        $uniqueFileName = uniqid() . '.' . $image->extension();
        $photoPath = $image->storeAs($dir, $uniqueFileName, 'uploads');
        return $photoPath;
    }

    public static function uploadVideo($video, string $dir): string
    {
        $uniqueFileName = uniqid() . '.' . $video->extension();
        $videoPath = $video->storeAs($dir, $uniqueFileName, 'public');
        return $videoPath;
    }

    public static function delete(string $FullImagePath)
    {
        $updatedPath = str_replace('http://127.0.0.1:8000/', '', $FullImagePath);

        if (File::exists($updatedPath)) {
            File::delete($updatedPath);
            return true;

        }
    }

}

