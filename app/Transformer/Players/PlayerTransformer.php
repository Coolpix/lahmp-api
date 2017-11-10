<?php

namespace App\Transformer\Players;

class PlayerTransformer {

    public function transform($player){
        return [
            'id' => $player->id,
            'photo' => $player->photo,
            'name' => $player->name,
            'teams' => $player->teams,
            'goals' => $player->goals,
            'assists' => $player->assists,
            'season' => $player->season
        ];
    }
}