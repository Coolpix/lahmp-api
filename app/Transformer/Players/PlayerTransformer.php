<?php

namespace App\Transformer\Players;

class PlayerTransformer {

    public function transform($player){
        return [
            'id' => $player->id,
            'photo' => $player->photo,
            'name' => $player->name,
            'team' => $player->team,
            'goals' => $player->goals,
            'assists' => $player->assists,
            'season' => $player->season
        ];
    }
}