<?php

namespace App\Http\Controllers\Api\V1\Producers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use App\Http\Requests\api\v1\ProducerRequest;
use App\Http\Resources\Api\V1\ProducerResource;
use App\Http\Resources\Api\V1\EventResourceCollection;
use App\Models\Producer;

class ProducerController extends Controller
{   
    public function index()
    {
        //
    }
   
    public function store(ProducerRequest $request)
    {
        $user = $request->user();        

        if($user->admin)
        {
            $producer = Producer::create($request->input('data.attributes'));
            return new ProducerResource($producer);
        } 

        if($user->id == $request->input('data.attributes.registered_user_id'))
        {
            $producer = Producer::create($request->input('data.attributes'));
            return new ProducerResource($producer);
        }       

        return response()->json([
            'message' => 'Unauthorized'
            ], 401);        
        
    }
    
    public function show(Request $request, $id)
    {
        if($request->user()->admin)
        {
            $user = RegisteredUser::find($id);
            $producer = $user->producer;

            if($producer)
            {
                return new ProducerResource($producer);
            }

            return response()->json(['errors' => [
                'status' => 404,
                'title'  => 'Not Found'
                ]
            ], 404);            
            
        }

        if($request->user()->producer->registered_user_id == $id)
        {
            return new ProducerResource($request->user()->producer);
        }
        
        return response()->json([
                'message' => 'Unauthorized'
                ], 401);
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }

    public function events($id)
    {
        $user = RegisteredUser::find($id);      
        $producer = $user->producer;
        if($producer)
        {
            $events = $producer->events;

            return new EventResourceCollection($events);                
        }  

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);       
        
    }
}
