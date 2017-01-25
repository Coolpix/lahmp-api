<?php

namespace App\Transformer;

class MatchTransformer {

    public function transform($match){
        return [
            'id' => $match->id,
            'teams' => $match->teams,
            'round' => $match->round,
            'goals' => $match->goals
        ];
    }
}