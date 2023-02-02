<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo('App\User'); 
    }
}
