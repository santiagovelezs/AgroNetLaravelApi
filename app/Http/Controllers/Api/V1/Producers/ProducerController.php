<?php

namespace App\Http\Controllers\Api\V1\Producers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\api\v1\ProducerRequest;
use App\Http\Resources\Api\V1\ProducerResource;
use App\Http\Resources\Api\V1\ProducerResourceCollection;
use App\Http\Resources\Api\V1\ProducerPublicResource;
use App\Http\Resources\Api\V1\EventResourceCollection;
use App\Http\Resources\Api\V1\ProductResourceCollection;
use App\Models\Producer;

class ProducerController extends Controller
{   
    public function index()
    {
        $producers = Producer::simplePaginate(25);
        
        return new ProducerResourceCollection($producers);
    }
   
    public function store(ProducerRequest $request)
    {
        $user = $request->user();     

        if($user->admin or $user->id == $request->input('data.attributes.id'))
        {
            //$producer = Producer::create($request->input('data.attributes'));
            //dd($producer);
            $producer = new Producer();
            $producer->id = $request->input('data.attributes.id');            
            $producer->save();                   
            return new ProducerResource($producer);
            //return new ProducerResource(Producer::find($request->input('data.attributes.id')));
        }       

        return response()->json([
            'message' => 'Unauthorized'
            ], 401);        
        
    }
    
    public function show(Request $request, $id)
    {
        if($request->user()->admin)
        {
            $user = User::find($id);
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

        if($request->user()->producer->id == $id)
        {
            return new ProducerResource($request->user()->producer);
        }
        
        return response()->json([
                'message' => 'Unauthorized'
                ], 401);
    }

    public function producerInfo(Request $request, $id)
    {
        $producer = Producer::find($id);        

        if($producer)
        {
            return new ProducerPublicResource($producer);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);     
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
        $producer = Producer::find($id);     
        
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

    public function products($id)
    {
        $producer = Producer::find($id);     
        
        if($producer)
        {
            $products = $producer->products;

            return new ProductResourceCollection($products);                
        }            

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);       
        
    }
}
