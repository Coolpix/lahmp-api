<?php

namespace App\Http\Controllers;

use App\Transformer\MatchTransformer;
use App\Transformer\MatchTeamTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Match;

class MatchController extends Controller
{
    protected $response;

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

    public function getBySeason($season){
        $matches = Match::where('round_id',"=",$season)->get();
        return $this->response->withItem($matches, new MatchTransformer());
    }
}
