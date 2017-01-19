<?php

namespace App\Http\Controllers;

use App\Transformer\MatchTransformer;
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
}
