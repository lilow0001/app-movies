<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
   // use HasFactory;
    protected $fillable = [
            'original_language',
            'original_title',
            'overview',
            'popularity',
            'poster_path',
            'title',
            'vote_average',
    ];
    
}
