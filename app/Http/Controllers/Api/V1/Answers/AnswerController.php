<?php

namespace App\Http\Controllers\Api\V1\Answers;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\AnswerRequest;
use App\Http\Resources\Api\V1\AnswerResource;
use App\Http\Requests\api\v1\QuestionRequest;
use App\Http\Resources\Api\V1\QuestionResource;
use App\Http\Resources\Api\V1\AnswerResourceCollection;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::simplePaginate(25);
        return new AnswerResourceCollection($answers);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $user = $request->user();        
        
        if($user->admin)
        {
            $answer = Answer::create($request->input('data.attributes'));
            return new AnswerResource($answer);
        } 

        if($user->producer->id == $request->input('data.attributes.producer_id'))
        {
            /*$question = Question::find($request->input('data.attributes.question_id'));
             
           // print_r($question);*/
         
           //SELECT pro.id as producers_id FROM questions as q INNER JOIN products as p ON q.product_id = p.id INNER JOIN  producers as pro ON  p.producer_id = pro.id WHERE q.id = 2
           $questionId = DB::table('questions as q')
                                ->join('products as p', 'q.product_id', '=', 'p.id')
                                ->join('producers as pro', 'p.producer_id', '=', 'pro.id')
                                ->select('pro.id')
                                ->where('q.id', $request->input('data.attributes.producer_id'))
                                ->get();
                                
           // print_r($questionId[0]->id);

            if($questionId[0]->id == $request->input('data.attributes.producer_id'))
            {
                
                $answer = Answer::create($request->input('data.attributes'));
                return new AnswerResource($answer);
            }
            else
            {
                return response()->json([
                    'message' => 'Unautorized',
                    'details' => 'invalid ',
                    ], 401); 
            }
        }
            else
            {
                return response()->json([
                    'message' => 'Unautorized',
                    'details' => 'invalid ',
                    ], 401); 
            }
           
             

        return response()->json([
            'message' => 'Unauthorized'
            ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answer = Answer::find($id);
        if($answer)
        {

            return new AnswerResource($answer);                
        }  

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404); 
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, $id)
    {
        
        $user = $request->user();        
        
        if($user->admin)
        {
            $Answer = Answer::find($id);
        } 

        if($user->producer->id == $request->input('data.attributes.producer_id'))
        {
         
           
           $questionId = DB::table('questions as q')
                                ->join('products as p', 'q.product_id', '=', 'p.id')
                                ->join('producers as pro', 'p.producer_id', '=', 'pro.id')
                                ->select('pro.id')
                                ->where('q.id', $request->input('data.attributes.producer_id'))
                                ->get();

            if($questionId[0]->id == $request->input('data.attributes.producer_id'))
            {
               
                $answer = Answer::find($id);
            }
            else
            {
                return response()->json([
                    'message' => 'Unautorized',
                    'details' => 'invalid ',
                    ], 401); 
            }
        }
            else
            {
                return response()->json([
                    'message' => 'Unautorized',
                    'details' => 'invalid ',
                    ], 401); 
            }
            if(isset($answer))
            {
                $answer->update($request->input('data.attributes'));
                return new AnswerResource($answer);
            }
    
            return response()->json(['errors' => [
                'status' => 404,
                'title'  => 'Not Found'
                ]
            ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->user()->admin)
        {
            $answer = Answer::find($id);
        }
        else 
        {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'invalid ',
                ], 401); 
        }        
        if($answer)
        {
            $answer->delete();
            return response(null, 204);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }
    
}
