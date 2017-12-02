<?php

namespace App\Http\Controllers;

use App\Assist;
use App\Goal;
use App\Transformer\Players\PlayerAssistTransformer;
use App\Transformer\Players\PlayerGoalTransformer;
use App\Transformer\Players\PlayerTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
        $players = Player::jsonPaginate();
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

    public function getBySeason($season){
        $players = Player::whereHas('season',function($query) use ($season){
            $query -> where('year',"=",$season);
        })->get();
        return $this->response->withCollection($players, new PlayerTransformer());
    }

    public function getByTeam($teamId){
        $players = Player::whereHas('team',function($query) use ($teamId){
            $query -> where('team_id',"=",$teamId);
        })->get();
        return $this->response->withCollection($players, new PlayerTransformer());
    }

    public function getGoals($id){
        $goals = Player::find($id)->goals;
        return $this->response->withItem($goals, new PlayerGoalTransformer());
    }

    public function getAssists($id){
        $assits = Player::find($id)->assists();
        return $this->response->withItem($assits, new PlayerAssistTransformer());
    }

    public function savePlayer(Request $request){
        $player = new Player;
        $player->photo = $request->photo;
        $player->name = $request->name;
        $player->save();
        $player->team()->associate($request->team)->save();
        $player->season()->associate($request->season)->save();
        foreach ($request->goals as $goal){
            try {
                $goalToSave = Goal::findOrFail($goal);
                $player->goals()->save($goalToSave);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Goal '. $goal .' Not Found');
            }
        }
        foreach ($request->assists as $assist){
            try {
                $assistToSave = Assist::findOrFail($assist);
                $player->assists()->save($assistToSave);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Assist '. $assist .' Not Found');
            }
        }
        return $this->response->withItem($player, new PlayerTransformer());
    }

    public function updatePlayer($playerID, Request $request){
        $player = Player::find($playerID);
        if ($player){
            $player->update([
                'name'=>$request->name,
                'photo'=>$request->photo
            ]);
            $player->season()->associate($request->season)->save();
            $player->team()->associate($request->team)->save();
            foreach ($request->goals as $goal){
                try {
                    $goalToSave = Goal::findOrFail($goal);
                    $player->goals()->save($goalToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Goal '. $goal .' Not Found');
                }
            };
            foreach ($request->assists as $assist){
                try {
                    $assistToSave = Assist::findOrFail($assist);
                    $player->assists()->save($assistToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Assist '. $assist .' Not Found');
                }
            };
            return $this->response->withItem($player, new PlayerTransformer());
        }else{
            return $this->response->errorNotFound('Player Not Found');
        }
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
