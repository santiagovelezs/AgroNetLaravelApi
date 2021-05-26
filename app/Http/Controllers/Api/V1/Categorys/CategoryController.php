<?php

namespace App\Http\Controllers\Api\V1\Categorys;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\CategoryRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Http\Resources\Api\V1\CategoryResourceCollection;
use App\Http\Resources\Api\V1\ProductResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::simplePaginate(25);
        return new CategoryResourceCollection($categorys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $user = $request->user();        
        
        if($user->admin)
        {

            $category = Category::create($request->input('data.attributes'));
            return new CategoryResource($category);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category)
        {

            return new CategoryResource($category);                
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $user = $request->user(); 
     
        if($user->admin)
        {
           
            $category = Category::find($id);
        }
        else
        {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'invalid ',
                ], 401); 
        }
      
        if(isset($category))
        {
            
            $category->update($request->input('data.attributes'));
           
            return new CategoryResource($category);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if($request->user()->admin)
        {
            $category = Category::find($id);
        }
             
        if($category)
        {
            $category->delete();
            return response(null, 204);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }

    public function products($id)
    {
        $category = Category::find($id);     
        
        if($category)
        {
            $products = $category->products;

            return new ProductResourceCollection($products);                
        }            

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);       
        
    }
}
