<?php

namespace App\Transformer;

class RoundTransformer {

    public function transform($round){
        return [
            'id' => $round->id,
            'name' => $round->name,
            'matches' => $round->matches
        ];
    }
}