<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Team;
use App\Transformer\TeamTransformer;
use App\Transformer\PlayerTeamTransformer;

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
        $teams = Team::where('season',"=",$season)->get();
        return $this->response->withCollection($teams, new TeamTransformer());
    }

    public function getPlayers($id){
        $team = Team::find($id)->players;
        return $this->response->withItem($team, new PlayerTeamTransformer());
    }
}
