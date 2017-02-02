<?php

namespace App\Transformer;

class PlayerTransformer {

    public function transform($player){
        return [
            'id' => $player->id,
            'photo' => $player->photo,
            'name' => $player->name,
            'teams' => $player->teams,
            'goals' => $player->goals,
            'assists' => $player->assists
        ];
    }
}