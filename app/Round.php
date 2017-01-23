<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * The matches that belong to the round.
     */
    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    /**
     * The season that belong to the round.
     */
    public function season()
    {
        return $this->belongsTo('App\Season');
    }
}
