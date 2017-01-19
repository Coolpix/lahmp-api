<?php

namespace App\Transformer;

class PlayerTransformer {

    public function transform($player){
        return [
            'id' => $player->id,
            'photo' => $player->photo,
            'teams' => $player->teams
        ];
    }
}