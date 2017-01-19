<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'team_local', 'team_away'
    ];

    /**
     * The teams that belong to the match.
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }
}
