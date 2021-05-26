<?php

namespace App\Http\Controllers\Api\V1\Questions;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\QuestionRequest;
use App\Http\Resources\Api\V1\QuestionResource;
use App\Http\Resources\Api\V1\QuestionResourceCollection;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::simplePaginate(25);
        return new QuestionResourceCollection($questions);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        
        $user = $request->user();        
        
        if($user->admin)
        {
            $question = Question::create($request->input('data.attributes'));
            return new QuestionResource($question);
        } 

        if($user->id == $request->input('data.attributes.user_id'))
        {
           
                $question = Question::create($request->input('data.attributes'));
                return new QuestionResource($question);
        }
            else
            {
                return response()->json([
                    'message' => 'Unauthorized',
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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        if($question)
        {

            return new QuestionResource($question);                
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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $user = $request->user();

        if($request->user()->admin)
        {
            $question = Question::find($id);
        }
        else if($user->id == $request->input('data.attributes.user_id'))
        {
            
            $question = $request->user()->questions()->find($id);
        }
        else
        {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'invalid ',
                ], 401); 
        }        
        if(isset($question))
        {
            $question->update($request->input('data.attributes'));
            return new QuestionResource($question);
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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->user()->admin)
        {
            $question = Question::find($id);
        }
        else 
        {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'invalid ',
                ], 401); 
        }        
        if($question)
        {
            $question->delete();
            return response(null, 204);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }
}
