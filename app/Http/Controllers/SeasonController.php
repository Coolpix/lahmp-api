<?php

namespace App\Http\Controllers;

use App\Round;
use App\Transformer\RoundTransformer;
use App\Transformer\SeasonRoundsTransformer;
use App\Transformer\SeasonTransformer;
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

    public function saveSeason(Request $request){
        //TODO: Acabar la creacion de un Season
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

}
