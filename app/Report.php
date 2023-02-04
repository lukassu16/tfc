<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const OPEN_STATUS   = 'OPEN';
    const TAKEN_STATUS  = 'TAKEN';
    const CLOSED_STATUS = 'CLOSED';

    protected $fillable = [
        'title', 'description', 'category', 'author_id', 'status'
    ];

    public function author()
    {
        return $this->belongsTo('App\User'); 
    }
}
