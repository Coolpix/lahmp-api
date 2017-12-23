<?php

namespace App\Transformer\Players;

class PlayerStatisticsTransformer {

    public function transform($player){
        return [
            'id' => $player->id,
            'photo' => $player->photo,
            'name' => $player->name,
            'team' => $player->team,
            'goals' => sizeof($player->goals),
            'assists' => sizeof($player->assists),
            'season' => $player->season
        ];
    }
}