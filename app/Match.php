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

    /**
     * The goals that belong to the match.
     */
    public function goals()
    {
        return $this->hasMany('App\Goal');
    }

    /**
     * The assists that belong to the match.
     */
    public function assists()
    {
        return $this->hasMany('App\Assist');
    }
}
