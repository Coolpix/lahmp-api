<?php

namespace App\Transformer\Players;

class PlayerGoalTransformer {

    public function transform($goal){
        return [$goal];
    }
}