<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\ShopRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\V1\ShopResource;
use App\Http\Resources\Api\V1\ShopResourceCollection;
use App\Models\Shop;
use App\Models\Producer;
use App\Models\Addr;

class ProducerShopController extends Controller
{
    public function index()
    {
        $shops = Shop::simplePaginate(25);
        
        return new ShopResourceCollection($shops);
    }

    public function store(ShopRequest $request)
    {
        $user = $request->user();     

        if($user->admin or $user->id == $request->input('data.attributes.producer_id'))
        {
            $shop = Shop::create($request->input('data.attributes'));                                      
            return new ShopResource($shop);            
        }       

        return response()->json([
            'message' => 'Unauthorized'
            ], 401);        
        
    }

    public function show(Request $request, $id)
    {
        $shop = Shop::find($id);        

        if($shop)
        {
            return new ShopResource($shop);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);                
        
    }
    

    public function calcDeliveryPrice(Request $request, $id)
    {
        // Query Params
        //$producer_id = $request->producer;
        $addrto = $request->addrto;
        
        $shop = Shop::findOrFail($id);        

        $addr = Addr::findOrFail($addrto);

        $geoto = $addr->geoLocation;

        $geofrom = $shop->addr->geoLocation;

        $max_dis = $shop->max_shipping_distance;

        

        /*$distance = DB::whereRaw('acos(sin(PI()*?/180)*sin(PI()*?/180.0)
                                +cos(PI()*?/180.0)
                                *cos(PI()*?/180.0)
                                *cos(PI()*?/180.0-PI()
                                *?/180.0))*6371',
                            [$geofrom->latitud, $geoto->latitud, $geofrom->latitud, $geoto->latitud, $geoto->longitud, $geofrom->longitud])                    
                    ->get();*/
        
        $distance = $this->calcDistance($geofrom->latitud,$geoto->latitud,$geofrom->longitud,$geoto->longitud);

        $inZone = $max_dis>=$distance ? True:False;
        
        return response()->json([
            'type' => 'DeliveryPrice',
            'attributes' => [
                'producer' => $shop->owner->id,
                'addrTo' => $addrto,
                'distance' => $distance,
                'per_km' => $shop->price_per_km,
                'cost' => round($shop->price_per_km*$distance),
                'inZone' => $inZone

            ]
        ]);
        
    }

    private function calcDistance($lt1, $lt2, $ln1, $ln2)
    {
        return acos(sin(pi()*$lt1/180)*sin(pi()*$lt2/180)+cos(pi()*$lt1/180)*cos(pi()*$lt2/180)*cos(pi()*$ln2/180-pi()*$ln1/180))*6371;
    }

    //punto venta controller
    //setCostPerKm
    public function update()
    {

    }
}