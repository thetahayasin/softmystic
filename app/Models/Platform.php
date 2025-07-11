<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
    ];

    protected $casts = [

    ];

    public function softwares()
    {
        return $this->hasMany(Software::class);
    }

    public function sitesetting()
    {
        return $this->hasOne(SiteSetting::class);
    }
}
