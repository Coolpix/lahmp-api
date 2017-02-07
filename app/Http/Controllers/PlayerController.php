<?php

namespace App\Http\Controllers;

use App\Goal;
use App\Transformer\Players\PlayerGoalTransformer;
use App\Transformer\Players\PlayerTransformer;
use App\Transformer\Players\PlayerTeamTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function getGoals($id){
        $goals = Player::find($id)->goals;
        return $this->response->withItem($goals, new PlayerGoalTransformer());
    }

    public function savePlayer(Request $request){
        $player = new Player;
        $player->photo = $request->photo;
        $player->name = $request->name;
        $player->save();
        $player->teams()->attach($request->team);
        try {
            $goalToSave = Goal::findOrFail($request->goal);
            $player->goals()->save($goalToSave);
        }catch (ModelNotFoundException $ex){
            return $this->response->errorNotFound('Goal '. $request->goal .' Not Found');
        }
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
