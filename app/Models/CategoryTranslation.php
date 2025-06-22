<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'locale_id', 'category_id',
    ];

    protected $casts = [

    ];

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
