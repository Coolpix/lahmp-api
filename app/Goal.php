<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'name', 'photo'
    ];

    /**
     * The match that belong to the goal.
     */
    public function match()
    {
        return $this->belongsTo('App\Match');
    }

    /**
     * The player that belong to the goal.
     */
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    /**
     * The team that belong to the goal.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
