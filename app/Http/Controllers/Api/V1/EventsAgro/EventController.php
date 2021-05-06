<?php

namespace App\Http\Controllers\Api\V1\EventsAgro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\EventRequest;
use App\Http\Resources\Api\V1\EventResource;
use App\Http\Resources\Api\V1\GeoLocationResource;
use App\Http\Resources\Api\V1\AddrResource;
use App\Http\Resources\Api\V1\EventResourceCollection;
use App\Models\Event;
use App\Models\GeoLocation;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        

        $eventos = Event::simplePaginate(25);

        return new EventResourceCollection($eventos);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $user = $request->user();

        if($user->admin)
        {           
            $event = Event::create($request->input('data.attributes'));
            return new EventResource($event);           
        }  
        //dd($user->producer->id);
        if($user->producer->registered_user_id == $request->input('data.attributes.user_id'))
        {
            $addr = $user->addrs()->find($request->input('data.attributes.addr_id'));
            //dd($addr);
            if($addr)
            {
                $event = Event::create($request->input('data.attributes'));
                return new EventResource($event);
            }
            else
            {
                return response()->json([
                    'message' => 'Unauthorized',
                    'details' => 'invalid Addr',
                    ], 401); 
            }
           
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
        $event = Event::find($id);

        if($event)
            return new EventResource($event);
        
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
        if($request->user()->admin)
        {
            $event = Event::find($id);
        }
        else
        {
            $user = $request->user();
            $event = $request->user()->producer->events->find($id);
        }        
        if(isset($event))
        {
            $event->update($request->input('data.attributes'));
            return new EventResource($event);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addr($id)
    {
        $event = Event::find($id);

        if($event)
        {
            $addr = $event->addr;
            return new AddrResource($addr);
        }            
        
        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }

    public function geoLocation($id)
    {
        $event = Event::find($id);

        if($event)
        {
            $geo = $event->addr->geoLocation;
            return new GeoLocationResource($geo);
        }            
        
        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }

    public function circundantes(Request $request, $lt, $lng, $val)
    {
        $events = Event::wherein('events.state', ["pendiente", "en_curso"])                                
                    ->join('addrs', 'events.addr_id', '=', 'addrs.id')
                    ->join('geo_locations', 'geo_locations.addr_id', '=', 'addrs.id')                    
                    ->whereRaw('acos(sin(PI()*geo_locations.latitud/180)*sin(PI()*?/180.0)
                                +cos(PI()*geo_locations.latitud/180.0)
                                *cos(PI()*?/180.0)
                                *cos(PI()*?/180.0-PI()
                                *geo_locations.longitud/180.0))*6371 < ? ',
                            [$lt, $lt, $lng, $val])                    
                    ->get();                            
        
        return new EventResourceCollection($events);
        
    }
    
}
