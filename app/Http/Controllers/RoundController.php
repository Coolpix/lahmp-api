<?php

namespace App\Http\Controllers;

use App\Match;
use App\Transformer\Rounds\RoundTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Round;

class RoundController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $rounds = Round::paginate(15);
        return $this->response->withPaginator($rounds, new RoundTransformer());
    }

    public function getByID($id){
        $round = Round::find($id);
        if(!$round){
            return $this->response->errorNotFound('Round Not Found');
        }else{
            return $this->response->withItem($round, new RoundTransformer());
        }
    }

    public function getBySeason($season){
        $rounds = Round::whereHas('season',function($query) use ($season){
            $query -> where('year',"=",$season);
        })->get();
        return $this->response->withCollection($rounds, new RoundTransformer());
    }

    public function saveRound(Request $request){
        $round = new Round;
        $round->name = $request->name;
        $round->save();
        $round->season()->associate($request->season)->save();
        foreach ($request->matches as $match){
            try {
                $matchToSave = Match::findOrFail($match);
                $round->matches()->save($matchToSave);
            }catch (ModelNotFoundException $ex){
                return $this->response->errorNotFound('Team '. $match .' Not Found');
            }
        }
        return $this->response->withItem($round, new RoundTransformer());
    }

    public function updateRound($roundID, Request $request){
        $round = Round::find($roundID);
        if ($round){
            $round->update([
                'name'=>$request->name
            ]);
            $round->season()->associate($request->season)->save();
            foreach ($request->matches as $match){
                try {
                    $matchToSave = Match::findOrFail($match);
                    $round->matches()->save($matchToSave);
                }catch (ModelNotFoundException $ex){
                    return $this->response->errorNotFound('Team '. $match .' Not Found');
                }
            };
            return $this->response->withItem($round, new RoundTransformer());
        }else{
            return $this->response->errorNotFound('Round Not Found');
        }
    }

    public function deleteRound($roundID){
        $round = Round::find($roundID);
        if ($round){
            $round->delete();
            return $this->response->withItem($round, new RoundTransformer());
        }else{
            return $this->response->errorNotFound('Round Not Found');
        }
    }

}
