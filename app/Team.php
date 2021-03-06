<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'logo', 'mini_logo', 'points'
    ];

    /**
     * The matches that belong to the Team.
     */
    public function matches()
    {
        return $this->belongsToMany('App\Match');
    }

    /**
     * The players that belong to the team.
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * The season that belong to the team.
     */
    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    /**
     * The goals that belong to the team.
     */
    public function goals()
    {
        return $this->hasMany('App\Goal','team_id');
    }

    /**
     * The goals against that belong to the team.
     */
    public function goals_against()
    {
        return $this->hasMany('App\Goal','team_against_id');
    }

    /**
     * The assits that belong to the team.
     */
    public function assists()
    {
        return $this->hasMany('App\Assist');
    }
}
