<?php

namespace App\Http\Controllers\Api\V1\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Requests\api\v1\NewsRequest;
use App\Http\Resources\Api\V1\NewsResource;
use App\Http\Resources\Api\V1\NewsResourceCollection;
use App\Models\User;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::simplePaginate(25);

        return new NewsResourceCollection($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $user = $request->user();         

        if($user->admin or ($user->id == $request->input('data.attributes.producer_id')))
        {
            $news = new News();
            $news->producer_id = User::find($request->input('data.attributes.producer_id'))->producer->id;
            $news->title = $request->input('data.attributes.title'); 
            $news->content = $request->input('data.attributes.content');            
            $news->save();
            return new NewsResource($news);
        }       

        return response()->json([
            'message' => 'Unauthorized'
            ], 401); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);

        if($news)       
            return new NewsResource($news);            

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
