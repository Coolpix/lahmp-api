<?php

namespace App\Transformer;

class TeamTransformer {

    public function transform($team){
        return [
            'id' => $team->id,
            'team' => $team->name,
            'team_logo' => $team->logo,
            'year' => $team->year
        ];
    }
}