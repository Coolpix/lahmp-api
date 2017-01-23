<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'logo', 'season'
    ];

    /**
     * The players that belong to the team.
     */
    public function players()
    {
        return $this->belongsToMany('App\Player');
    }
}
