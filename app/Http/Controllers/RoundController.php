<?php

namespace App\Http\Controllers;

use App\Transformer\RoundTransformer;
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

}
