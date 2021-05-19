<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\ShopRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\V1\ShopResource;
use App\Http\Resources\Api\V1\ShopResourceCollection;
use App\Models\Shop;

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
            //dd($shop);                              
            return new ShopResource($shop);            
        }       

        return response()->json([
            'message' => 'Unauthorized'
            ], 401);        
        
    }

    public function calcPrice(Request $request)
    {
        $producer_id = $request->producer;
        $addrto = $request->addrto;                           
        
        return response()->json([
            'type' => 'DeliveryPrice',
            'attributes' => [
                'producer' => $producer_id,
                'addrTo' => $addrto,
                'distance' => 8,
                'per_km' => 900,
                'cost' => 7200
            ]
        ]);
        
    }

    //punto venta controller
    public function setCostPerKm()
    {

    }
}