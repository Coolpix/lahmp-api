<?php

namespace App\Http\Controllers;

use App\Assist;
use App\Transformer\Assists\AssistTransformer;
use App\Transformer\Assists\AssistGoalTransformer;
use App\Transformer\Assists\AssistMatchTransformer;
use App\Transformer\Assists\AssistPlayerTransformer;
use App\Transformer\Assists\AssistTeamTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Http\Requests;
use EllipseSynergie\ApiResponse\Contracts\Response;

class AssistController extends Controller
{
    protected $response;
    use SoftDeletes;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
        $assists = Assist::jsonPaginate(15);
        return $this->response->withPaginator($assists, new AssistTransformer());
    }

    public function getByID($id){
        $assist = Assist::find($id);
        if(!$assist){
            return $this->response->errorNotFound('Assist Not Found');
        }else{
            return $this->response->withItem($assist, new AssistTransformer());
        }
    }

    public function getTeam($id){
        $team = Assist::find($id)->team;
        return $this->response->withItem($team, new AssistTeamTransformer());
    }

    public function getPlayer($id){
        $player = Assist::find($id)->player;
        return $this->response->withItem($player, new AssistPlayerTransformer());
    }

    public function getMatch($id){
        $match = Assist::find($id)->match;
        return $this->response->withItem($match, new AssistMatchTransformer());
    }

    public function getGoal($id){
        $goal = Assist::find($id)->goal;
        return $this->response->withItem($goal, new AssistGoalTransformer());
    }

    public function saveAssist(Request $request){
        $assist = new Assist();
        $assist -> save();
        $assist -> goal()->associate($request->goal)->save();
        $assist -> player()->associate($request->player)->save();
        $assist -> team()->associate($request->team)->save();
        $assist -> match()->associate($request->match)->save();
        return $this->response->withItem($assist, new AssistTransformer());
    }

    public function deleteAssist($assistID){
        $assist = Assist::find($assistID);
        if ($assist){
            $assist->delete();
            return $this->response->withItem($assist, new AssistTransformer());
        }else{
            return $this->response->errorNotFound('Assist Not Found');
        }
    }
}
