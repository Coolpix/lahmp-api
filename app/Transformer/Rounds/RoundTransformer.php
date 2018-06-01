<?php

namespace App\Transformer\Rounds;

class RoundTransformer {

    public function transform($round){
        return [
            'id' => $round->id,
            'name' => $round->name,
            'date' => $round->date,
            'matches' => $round->matches,
            'season' => $round->season
        ];
    }
}