<?php

namespace App\Transformer\Assists;

class AssistTransformer {

    public function transform($assist){
        return [
            'id' => $assist->id,
            'team' => $assist->team,
            'player' => $assist->player,
            'match' => $assist->match,
            'goal' => $assist->goal,
            'season' => $assist->season
        ];
    }
}