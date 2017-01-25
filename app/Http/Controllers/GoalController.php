<?php

namespace App\Http\Controllers;

use App\Transformer\GoalMatchTransformer;
use App\Transformer\GoalTransformer;
use App\Transformer\MatchRoundTransformer;
use App\Transformer\MatchTransformer;
use App\Transformer\MatchTeamTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Goal;

class GoalController extends Controller
{
    protected $response;
    use SoftDeletes;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $goals = Goal::paginate(15);
        return $this->response->withPaginator($goals, new GoalTransformer());
    }

    public function getByID($id){
        $goal = Goal::find($id);
        if(!$goal){
            return $this->response->errorNotFound('Goal Not Found');
        }else{
            return $this->response->withItem($goal, new GoalTransformer());
        }
    }

    public function getTeam($id){
        $team = Goal::find($id)->team;
        return $this->response->withItem($team, new GoalTransformer());
    }

    public function getPlayer($id){
        $player = Goal::find($id)->player;
        return $this->response->withItem($player, new GoalTransformer());
    }

    public function getMatch($id){
        $match = Goal::find($id)->match;
        return $this->response->withItem($match, new GoalMatchTransformer());
    }

    /*public function getMatch($id){
        $matches = Match::whereHas('teams',function($query) use ($season){
            $query -> where('season',"=",$season);
        })->get();
        return $this->response->withCollection($matches, new MatchTransformer());
    }*/

    public function saveMatch(Request $request){
        $match = new Match;
        $match->save();
        $match->round()->associate($request->round)->save();
        $match->teams()->attach([$request->teams[0],$request->teams[1]]);
        return $this->response->withItem($match, new MatchTransformer());
    }

    public function updateMatch($match){
        $match = Match::find($match);
        if ($match){
            return $this->response->withItem($match, new MatchTransformer());
        }else{
            return $this->response->errorNotFound('Match Not Found');
        }
    }

    public function deleteMatch($matchID){
        $match = Match::find($matchID);
        if ($match){
            $match->delete();
            return $this->response->withItem($match, new MatchTransformer());
        }else{
            return $this->response->errorNotFound('Match Not Found');
        }
    }
}
