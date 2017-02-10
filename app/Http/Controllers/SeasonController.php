<?php

namespace App\Http\Controllers;

use App\Round;
use App\Team;
use App\Transformer\Seasons\SeasonRoundsTransformer;
use App\Transformer\Seasons\SeasonTeamsTransformer;
use App\Transformer\Seasons\SeasonTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Season;

class SeasonController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $seasons = Season::paginate(15);
        return $this->response->withPaginator($seasons, new SeasonTransformer());
    }

    public function getByID($id){
        $season = Season::find($id);
        if(!$season){
            return $this->response->errorNotFound('Season Not Found');
        }else{
            return $this->response->withItem($season, new SeasonTransformer());
        }
    }

    public function getRounds($id){
        $rounds = Season::find($id)->rounds;
        if(!$rounds){
            return $this->response->errorNotFound('Season Not Found');
        }else{
            return $this->response->withItem($rounds, new SeasonRoundsTransformer());
        }
    }

    public function getTeams($id){
        $teams = Season::find($id)->teams;
        if(!$teams){
            return $this->response->errorNotFound('Season Not Found');
        }else{
            return $this->response->withItem($teams, new SeasonTeamsTransformer());
        }
    }

    public function saveSeason(Request $request){
        $season = new Season;
        $season->name = $request->name;
        $season->year = $request->year;
        $season->save();
        foreach ($request->rounds as $round){
            try {
                $roundToSave = Round::findOrFail($round);
                $season->rounds()->save($roundToSave);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Round '. $round .' Not Found');
            }
        };
        foreach ($request->teams as $team){
            try {
                $teamToSave = Team::findOrFail($team);
                $season->teams()->save($teamToSave);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Team '. $team .' Not Found');
            }
        }
        return $this->response->withItem($season, new SeasonTransformer());
    }

    public function deleteSeason($seasonID){
        $season = Season::find($seasonID);
        if ($season){
            $season->delete();
            return $this->response->withItem($season, new SeasonTransformer());
        }else{
            return $this->response->errorNotFound('Season Not Found');
        }
    }

    public function updateSeason($seasonID, Request $request){
        $season = Season::find($seasonID);
        if ($season){
            $season->update([
                'name'=>$request->name,
                'year'=>$request->year
            ]);
            foreach ($request->rounds as $round){
                try {
                    $roundToSave = Round::findOrFail($round);
                    $season->rounds()->save($roundToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Round '. $round .' Not Found');
                }
            };
            foreach ($request->teams as $team){
                try {
                    $teamToSave = Team::findOrFail($team);
                    $season->teams()->save($teamToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Team '. $team .' Not Found');
                }
            }
            return $this->response->withItem($season, new SeasonTransformer());
        }else{
            return $this->response->errorNotFound('Season Not Found');
        }
    }
}
