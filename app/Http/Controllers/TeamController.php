<?php

namespace App\Http\Controllers;

use App\Transformer\Teams\TeamGoalTransformer;
use App\Transformer\Teams\TeamPlayerTransformer;
use App\Transformer\Teams\TeamTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Team;

class TeamController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $teams = Team::paginate(15);
        return $this->response->withPaginator($teams, new TeamTransformer());
    }

    public function getByID($id){
        $team = Team::find($id);
        if(!$team){
            return $this->response->errorNotFound('Team Not Found');
        }else{
            return $this->response->withItem($team, new TeamTransformer());
        }
    }

    public function getBySeason($season){
        $teams = Team::whereHas('season', function($q) use ($season){
            $q->where('year', $season);
        })->get();
        return $this->response->withCollection($teams, new TeamTransformer());
    }

    public function getPlayers($id){
        $team = Team::find($id)->players;
        return $this->response->withItem($team, new TeamPlayerTransformer());
    }

    public function getGoals($id){
        $goals = Team::find($id)->goals;
        return $this->response->withItem($goals, new TeamGoalTransformer());
    }

    public function saveTeam(Request $request){
        $team = new Team;
        $team->name = $request->name;
        $team->logo = $request->logo;
        $team->season = $request->season;
        $team->save();
        $team->players()->attach($request->players);
        return $this->response->withItem($team, new TeamTransformer());
    }

    public function deleteTeam($teamID){
        $team = Team::find($teamID);
        if ($team){
            $team->delete();
            return $this->response->withItem($team, new TeamTransformer());
        }else{
            return $this->response->errorNotFound('Team Not Found');
        }
    }
}
