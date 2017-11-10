<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name', 'year'
    ];

    /**
     * The rounds that belong to the season.
     */
    public function rounds()
    {
        return $this->hasMany('App\Round');
    }

    /**
     * The players that belong to the season.
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * The matches that belong to the season.
     */
    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    /**
     * The teams that belong to the season.
     */
    public function teams()
    {
        return $this->hasMany('App\Team')->orderBy('points','desc');
    }
}
