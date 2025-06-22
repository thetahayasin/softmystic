<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'file_size', 'version', 'author_id', 'logo', 'download_url', 'buy_url', 'downloads', 'category_id', 'user_id', 'license_id', 'platform_id', 'is_sponsored', 'is_featured', 'screenshots', 'total_ratings', 'average_rating'
    ];

    protected $casts = [
        'screenshots' => 'array'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'software_requirements')->withTimestamps();
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function softwareTranslations()
    {
        return $this->hasMany(SoftwareTranslation::class);
    }


    protected static function booted(): void
    {
        static::deleted(function (Software $software) {
            if (is_array($software->screenshots)) {
                foreach ($software->screenshots as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    
        static::updating(function (Software $software) {
            $originalScreenshots = $software->getOriginal('screenshots') ?? [];
            $newScreenshots = $software->screenshots ?? [];
    
            $originalScreenshots = is_array($originalScreenshots) ? $originalScreenshots : json_decode($originalScreenshots, true);
            $newScreenshots = is_array($newScreenshots) ? $newScreenshots : json_decode($newScreenshots, true);
    
            if ($originalScreenshots !== $newScreenshots) {
                $filesToDelete = array_diff($originalScreenshots, $newScreenshots);
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    }

    public function getReadableFilesizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }

}
