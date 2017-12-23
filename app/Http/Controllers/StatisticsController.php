<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Player;
use App\Transformer\Players\PlayerStatisticsTransformer;
use EllipseSynergie\ApiResponse\Contracts\Response;

class StatisticsController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getPlayersMostScorer($season){
        $players = Player::whereHas('season',function($query) use ($season){
            $query -> where('year',"=",$season);
        })->get();
        return $this->response->withCollection($players, new PlayerStatisticsTransformer());
    }

}
