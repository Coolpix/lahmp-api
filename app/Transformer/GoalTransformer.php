<?php

namespace App\Transformer;

class GoalTransformer {

    public function transform($goal){
        return [
            'id' => $goal->id,
            'team' => $goal->team,
            'player' => $goal->player,
            'match' => $goal->match
        ];
    }
}