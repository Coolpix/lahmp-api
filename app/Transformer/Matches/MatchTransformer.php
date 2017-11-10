<?php

namespace App\Transformer\Matches;

class MatchTransformer {

    public function transform($match){
        return [
            'id' => $match->id,
            'teams' => $match->teams,
            'round' => $match->round,
            'goals' => $match->goals,
            'assists' => $match->assists,
            'season' => $match->season
        ];
    }
}