<?php

namespace App\Transformer\Rounds;

class RoundTransformer {

    public function transform($round){
        return [
            'id' => $round->id,
            'name' => $round->name,
            'matches' => $round->matches,
            'season' => $round->season
        ];
    }
}