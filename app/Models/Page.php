<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Page extends Model
{
    protected $fillable = ['slug'];

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translationByLocale($locale_id)
    {
        return $this->translations()->where('locale_id', $locale_id)->first();
    }
}
