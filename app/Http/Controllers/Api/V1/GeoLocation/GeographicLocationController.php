<?php

namespace App\Http\Controllers\Api\V1\GeoLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\GeoLocationRequest;
use App\Models\GeoLocation;
use App\Models\Addr;
use App\Http\Resources\Api\V1\GeoLocationResource;
use App\Http\Resources\Api\V1\GeoLocationResourceCollection;
use Illuminate\Support\Facades\DB;


class GeographicLocationController extends Controller
{    
    public function index()
    {
        $geos = GeoLocation::simplePaginate(25);

        return new GeoLocationResourceCollection($geos);
    }
    
    public function store(GeoLocationRequest $request)
    {
        $user = $request->user();

        $addr = $user->addrs->find($request->input('data.attributes.addr_id'));        
              
        if($user->admin or  $addr)
        {
            //$geo = GeoLocation::create($request->input('data.attributes'));
            $geo = new GeoLocation();
            $geo->latitud = $request->input('data.attributes.latitud');
            $geo->longitud = $request->input('data.attributes.longitud');
            $geo->addr_id = $request->input('data.attributes.addr_id');
            $geo->save();
            return new GeoLocationResource($geo);
        }

        return response()->json([
            'message' => 'Unauthorized'
            ], 401); 
        
    }
    
    public function show($id)
    {
        $geo = GeoLocation::find($id);

        if($geo)
        {
            return new GeoLocationResource($geo);
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

    public function circundantes(Request $request, $lt, $lng, $val)
    {
        // Distancia entre dos puntos no aplica.
        //select sqrt(pow((-5-geo.latitud), 2) + pow((75-geo.longitud), 2)) FROM geo_locations geo;
        //
        // Distancia entre dos coordenadas
        // select * from geo_locations geo 
        // where 
        // acos(sin(PI()*geo.latitud/180)*sin(PI()*-5/180.0)+cos(PI()*geo.latitud/180.0)*cos(PI()*-5/180.0)*cos(PI()*75/180.0-PI()
        //    *geo.longitud/180.0))*6371 < {kilometers};

        //select acos(sin(PI()*geo.latitud/180)*sin(PI()*5.06808959869480/180.0)+cos(PI()*geo.latitud/180.0)*cos(PI()*5.06808959869480/180.0)*cos(PI()*-75.51734696649200/180.0-PI()*geo.longitud/180.0))*6371 from geo_locations geo;
        
        /*$geos = DB::table('geo_locations')
                    ->whereRaw('sqrt(pow((?-geo_locations.latitud), 2) + pow((?-geo_locations.longitud), 2)) < ?',[$lt, $lng, $val])
                    ->get();*/

        $geos = DB::table('geo_locations')
                    ->join('addrs', 'geo_locations.addr_id', '=', 'addrs.id')
                    ->join('events', 'events.addr_id', '=', 'addrs.id')                    
                    ->whereRaw('acos(sin(PI()*geo_locations.latitud/180)*sin(PI()*?/180.0)
                                +cos(PI()*geo_locations.latitud/180.0)
                                *cos(PI()*?/180.0)
                                *cos(PI()*?/180.0-PI()
                                *geo_locations.longitud/180.0))*6371 < ? ',
                            [$lt, $lt, $lng, $val])
                    ->whereRaw('events.state = ? OR events.state = ?', ["pendiente", "en_curso"])
                    ->get();            
        
        return new GeoLocationResourceCollection($geos);
        
    }
}
