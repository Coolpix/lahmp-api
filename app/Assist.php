<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assist extends Model
{
    protected $fillable = [

    ];

    /**
     * The goal that belong to the assist.
     */
    public function goal()
    {
        return $this->belongsTo('App\Goal');
    }

    /**
     * The team that belong to the assist.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    /**
     * The player that belong to the assist.
     */
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    /**
     * The match that belong to the assist.
     */
    public function match()
    {
        return $this->belongsTo('App\Match');
    }
}
