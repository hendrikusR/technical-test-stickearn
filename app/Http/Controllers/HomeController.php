<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function play()
    {

        // get data current score by user id
        $currentScore = $this->getCurrentScore();

        //get data current_page if empty set 1 if not get from database
        $page = !empty($currentScore) ? $currentScore->current_page : 1;

        //get question from api
        $response = $this->getQuestion($page);


        return view("play", [
            "page" => $page,
            "score" => !empty($currentScore) ? $currentScore->score : 0,
            "question" => strtoupper(str_shuffle($response['name']))
        ]);
    }

    public function answer(Request $request)
    {

        //get answer from request
        $answer = strtolower($request->answer);

        //get original question from api
        $originalQuestion = strtolower($this->getQuestion($request->page)['name']);


        //check if answer identity with originalQuestion
        if($answer === $originalQuestion) {

            //set page = request page + 1
            $page = $request->page + 1;


            //check if current score if empty and call addScore function if not empty call updateScore function
            if(empty($this->getCurrentScore())) {
                $this->addScore();
            } else {
                $this->updateScore($page);
            }

            return json_encode([
                'code' => 200,
                'answer' => true,
            ]);    
            
        } else {

            // deduct score when answer is wrong
            $this->deductScore($request->page);

            return json_encode([
                'code' => 200,
                'answer' => false
            ]);
        }
    }


    public function getQuestion($page = 1)
    {
        
        // initiate guzzle http client
        $client = new \GuzzleHttp\Client();

        //call api using guzzle
        $response = $client->request('GET', 'https://api.predic8.de:443/shop/products/?page='.$page.'&limit=1');
        $response = json_decode($response->getBody()->getContents(), true);

        return [
            'name' => $response['products'][0]['name'],
            'page' => $page
        ];
        
    }


    /**
     * get data current score from getCurrentScore function with condition user_id session from user login
    */
    public function getCurrentScore()
    {

        return DB::table('scores')
            ->select('score','current_page')
            ->where('user_id', Auth::user()->id)
            ->first();
    }


    /**
     * set addScore function with default value current_page = 2, score 10, user_id session from user login
     */
    public function addScore()
    {
        return DB::table('scores')->insert([
            'user_id' => Auth::user()->id,
            'score' => 10,
            'current_page' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }


    // deduct current score if answer is false
    public function deductScore($page)
    {
        
        $params = [
            'score' => $this->getCurrentScore()->score - 10,
            'page' => $page
        ];
        
        return $this->updateQuery($params);
        
    }

    // update current score if answer is true
    public function updateScore($page)
    {
        $params = [
            'score' => $this->getCurrentScore()->score + 10,
            'page' => $page
        ];

        return $this->updateQuery($params);
    }


    // set function updateQuery to update scores table
    public function updateQuery($params)
    {
        return DB::table('scores')
            ->where('user_id', Auth::user()->id)
            ->update([
                'score' => $params['score'],
                'current_page' => $params['page'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
