<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Team;
use App\Transformer\TeamTransformer;

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
}
