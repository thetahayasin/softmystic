<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'locale_id', 'category_id',
    ];

    protected $casts = [

    ];

    public function locale(): HasOne
    {
        return $this->hasOne(Locale::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
