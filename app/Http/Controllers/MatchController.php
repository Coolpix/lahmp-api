<?php

namespace App\Http\Controllers;

use App\Transformer\MatchRoundTransformer;
use App\Transformer\MatchTransformer;
use App\Transformer\MatchTeamTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Match;
use App\Round;
use App\Team;

class MatchController extends Controller
{
    protected $response;
    use SoftDeletes;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $matches = Match::paginate(15);
        return $this->response->withPaginator($matches, new MatchTransformer());
    }

    public function getByID($id){
        $match = Match::find($id);
        if(!$match){
            return $this->response->errorNotFound('Match Not Found');
        }else{
            return $this->response->withItem($match, new MatchTransformer());
        }
    }

    public function getTeams($id){
        $teams = Match::find($id)->teams;
        return $this->response->withItem($teams, new MatchTeamTransformer());
    }

    public function getRound($id){
        $round = Match::find($id)->round;
        return $this->response->withItem($round, new MatchRoundTransformer());
    }

    public function getBySeason($season){
        $matches = Match::whereHas('teams',function($query) use ($season){
            $query -> where('season',"=",$season);
        })->get();
        return $this->response->withCollection($matches, new MatchTransformer());
    }

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
