<?php

namespace App\Http\Controllers;

use App\Assist;
use App\Goal;
use App\Team;
use App\Transformer\Matches\MatchGoalTransformer;
use App\Transformer\Matches\MatchRoundTransformer;
use App\Transformer\Matches\MatchTransformer;
use App\Transformer\Matches\MatchTeamTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Match;
/**
 * @SWG\Info(title="Matches API", version="0.1")
 */
class MatchController extends Controller
{
    protected $response;
    use SoftDeletes;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @SWG\Get(
     *     path="/api/matches.json",
     *     @SWG\Response(response="200", description="Matchs List")
     * )
     */
    public function index(){
        $matches = Match::jsonPaginate(15);
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

    public function getGoals($id){
        $goals = Match::find($id)->goals;
        return $this->response->withItem($goals, new MatchGoalTransformer());
    }

    public function getBySeason($season){
        $matches = Match::whereHas('season',function($query) use ($season){
            $query -> where('year',"=",$season);
        })->get();
        return $this->response->withCollection($matches, new MatchTransformer());
    }

    public function getByRound($round){
        $matches = Match::whereHas('round',function($query) use ($round){
            $query -> where('id',"=",$round);
        })->get();
        return $this->response->withCollection($matches, new MatchTransformer());
    }

    public function saveMatch(Request $request){
        $match = new Match;
        $match->save();
        $match->finish = $request->finish;
        $match->round()->associate($request->round)->save();
        $match->teams()->attach([$request->teams[0],$request->teams[1]]);
        $match->season()->associate($request->season)->save();
        return $this->response->withItem($match, new MatchTransformer());
    }

    public function updateMatch($matchID, Request $request){
        $match = Match::find($matchID);
        if ($match){
            $match->update([
                'finish'=>$request->finish,
            ]);
            $match->round()->associate($request->round)->save();
            $match->season()->associate($request->season)->save();
            try{
                Team::findOrFail($request->teams[0]);
                Team::findOrFail($request->teams[1]);
                $match->teams()->detach();
                $match->teams()->attach([$request->teams[0],$request->teams[1]]);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Any Team Not Found');
            };
            foreach ($request->goals as $goal){
                try {
                    $goalToSave = Goal::findOrFail($goal);
                    $match->goals()->save($goalToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Goal '. $goal .' Not Found');
                }
            };
            foreach ($request->assists as $assist){
                try {
                    $assistToSave = Assist::findOrFail($assist);
                    $match->assists()->save($assistToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Assist '. $assist .' Not Found');
                }
            };
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
