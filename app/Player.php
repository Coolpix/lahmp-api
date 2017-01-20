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
}
