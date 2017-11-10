<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name', 'photo'
    ];

    /**
     * The teams that belong to the player.
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    /**
     * The goals that belong to the player.
     */
    public function goals()
    {
        return $this->hasMany('App\Goal');
    }

    /**
     * The assists that belong to the player.
     */
    public function assists()
    {
        return $this->hasMany('App\Assist');
    }

    /**
     * The season that belong to the player.
     */
    public function season()
    {
        return $this->belongsTo('App\Season');
    }
}
