<?php

namespace App\Http\Controllers\Api\V1\Products;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\ProductRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Resources\Api\V1\ProductResourceCollection;
use App\Http\Resources\Api\V1\QuestionResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::simplePaginate(25);
        return new ProductResourceCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $user = $request->user();        
        
        if($user->admin)
        {
            $product = Product::create($request->input('data.attributes'));
            return new ProductResource($product);
        } 

        if($user->producer->id == $request->input('data.attributes.producer_id'))
        {
           
                $product = Product::create($request->input('data.attributes'));
                return new ProductResource($product);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product)
        {

            return new ProductResource($product);                
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        if($request->user()->admin)
        {
            $product = Product::find($id);
        }
        else
        {
            $user = $request->user();
            $product = $request->user()->products()->find($id);
        }        
        if(isset($product))
        {
            $product->update($request->input('data.attributes'));
            return new ProductResource($product);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {if($request->user()->admin)
        {
            $product = Product::find($id);
        }
        else
        {
            $user = $request->user();
            $product = $request->user()->products()->find($id);
        }        
        if($product)
        {
            $product->delete();
            return response(null, 204);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }
    public function questions($id)
    {
       
        $product = Product::find($id);     
        
        if($product)
        {
            $questions = $product->questions;

            return new QuestionResourceCollection($questions);                
        }            

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);       
        
    }
}
