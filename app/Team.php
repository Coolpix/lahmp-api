<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'logo', 'points'
    ];

    /**
     * The players that belong to the team.
     */
    public function players()
    {
        return $this->belongsToMany('App\Player');
    }

    /**
     * The season that belong to the team.
     */
    public function season()
    {
        return $this->belongsTo('App\Season');
    }
}
