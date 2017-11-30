<?php

namespace App\Transformer\Teams;

class TeamTransformer {

    public function transform($team){
        return [
            'id' => $team->id,
            'name' => $team->name,
            'logo' => $team->logo,
            'mini_logo' => $team->mini_logo,
            'points' => $team->points,
            'season' => $team->season,
            'players' => $team->players,
            'matches' => $team->matches,
            'goals' => $team->goals,
            'assists' => $team->assists
        ];
    }
}