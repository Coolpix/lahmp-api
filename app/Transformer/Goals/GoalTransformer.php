<?php

namespace App\Transformer\Goals;

class GoalTransformer {

    public function transform($goal){
        return [
            'id' => $goal->id,
            'team' => $goal->team,
            'player' => $goal->player,
            'match' => $goal->match,
            'assist' => $goal->assist,
            'season' => $goal->season
        ];
    }
}