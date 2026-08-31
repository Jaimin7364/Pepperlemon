<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $images = json_decode($this->images, true);
        if (!is_array($images)) {
            $images = !empty($this->images) ? [$this->images] : [];
        }
        $firstImg = count($images) > 0 ? $images[0] : null;
        if (!$firstImg) {
            return asset('images/placeholder.svg');
        }
        if (str_starts_with($firstImg, 'http://') || str_starts_with($firstImg, 'https://')) {
            return $firstImg;
        }
        $normalizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $firstImg);
        // If it's an uploaded file OR starts with 'images/', assume it's valid to prevent fallback loops
        if (str_starts_with($firstImg, 'uploads/') || str_starts_with($firstImg, 'images/')) {
            return asset($firstImg);
        }
        if (file_exists(public_path($normalizedPath))) {
            return asset($firstImg);
        }
        return asset('images/placeholder.svg');
    }

    public function getAllImageUrlsAttribute(): array
    {
        $images = json_decode($this->images, true);
        if (!is_array($images)) {
            $images = !empty($this->images) ? [$this->images] : [];
        }
        $urls = [];
        foreach ($images as $img) {
            if (empty($img)) continue;
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $urls[] = $img;
            } else {
                $normalizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $img);
                if (str_starts_with($img, 'uploads/') || str_starts_with($img, 'images/')) {
                    $urls[] = asset($img);
                } elseif (file_exists(public_path($normalizedPath))) {
                    $urls[] = asset($img);
                } else {
                    $urls[] = asset('images/placeholder.svg');
                }
            }
        }
        return count($urls) > 0 ? $urls : [asset('images/placeholder.svg')];
    }
}
