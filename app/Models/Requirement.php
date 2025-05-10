<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [

    ];

    public function softwares()
    {
        return $this->belongsToMany(Software::class, 'software_requirements')->withTimestamps();
    }
}
