<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class PageTranslation extends Model
{
    protected $fillable = ['page_id', 'locale_id', 'title', 'content'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }


}
