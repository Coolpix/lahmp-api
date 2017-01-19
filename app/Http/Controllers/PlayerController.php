<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Player;
use App\Transformer\PlayerTransformer;

class PlayerController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $players = Player::paginate(15);
        return $this->response->withPaginator($players, new PlayerTransformer());
    }
}
