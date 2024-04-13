<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageManager
{
    public static function uploadFile(string $dir, $image = null)
    {
        if ($image != null) {
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
    
            if ($image->getClientOriginalExtension() == 'gif' || $image->getClientOriginalExtension() == 'svg' || $image->getClientOriginalExtension() == 'mp4') {
                $image->move(storage_path('app/public') . "/" . $dir . "/", $imageName);
            } else {
                Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
            }
            return 'storage/' . $dir . '/' . $imageName;
        } else {
            return null;
        }
    }

    public static function updateFile(string $dir, $old_image, $image = null)
    {
        if (file_exists(public_path($old_image))) {
            File::delete(public_path($old_image));
        }
        $imageName = ImageManager::uploadFile($dir, $image);
        return $imageName;
    }

    public static function deleteFile($full_path)
    {
        if (file_exists(public_path($full_path))) {
            File::delete(public_path($full_path));
        }
        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }
}
