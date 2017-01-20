<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [

    ];

    /**
     * The teams that belong to the match.
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    /**
     * The round that belong to the match.
     */
    public function round()
    {
        return $this->belongsTo('App\Round');
    }
}
