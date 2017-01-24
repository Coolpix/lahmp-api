<?php

namespace App\Http\Controllers;

use App\Transformer\PlayerTransformer;
use App\Transformer\PlayerTeamTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Player;

class PlayerController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $players = Player::paginate(15);
        return $this->response->withPaginator($players, new PlayerTransformer());
    }

    public function getByID($id){
        $player = Player::find($id);
        if(!$player){
            return $this->response->errorNotFound('Player Not Found');
        }else{
            return $this->response->withItem($player, new PlayerTransformer());
        }
    }

    public function getTeams($id){
        $teams = Player::find($id)->teams;
        return $this->response->withItem($teams, new PlayerTeamTransformer());
    }

    public function savePlayer(Request $request){
        $player = new Player;
        $player->photo = $request->photo;
        $player->name = $request->name;
        $player->save();
        return $this->response->withItem($player, new PlayerTransformer());
    }

    public function deletePlayer($playerID){
        $player = Player::find($playerID);
        if ($player){
            $player->delete();
            return $this->response->withItem($player, new PlayerTransformer());
        }else{
            return $this->response->errorNotFound('Player Not Found');
        }
    }
}
