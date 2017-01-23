<?php

namespace App\Transformer;

class SeasonTransformer {

    public function transform($season){
        return [
            'id' => $season->id,
            'name' => $season->name,
            'year' => $season->year,
            'rounds' => $season->rounds
        ];
    }
}