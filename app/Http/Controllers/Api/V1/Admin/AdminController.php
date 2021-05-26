<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AdminResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Resources\Api\V1\AdminResourceCollection;
use App\Http\Requests\api\v1\AdminRequest;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::simplePaginate(25);
        
        return new AdminResourceCollection($admin);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $admin = new Admin();
        $admin->id = $request->input('data.attributes.id');
        $admin->save();

        return new AdminResource($admin);         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);        

        if($admin)
        {
            return new AdminResource($admin);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
       
        $admin = Admin::find($id);           
             
        if(isset($admin))
        {
            $admin->update($request->input('data.attributes'));
            return new AdminResource($addr);
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
        if($id != 1)
        {
            $admin = Admin::find($id);   
            $admin->delete();

            return response(null, 204);            
        }
        else
        {
            return response()->json([
                'message' => 'Unauthorized'
                ], 401);
        }

        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);
    }

    public function softDeleteUser($id)
    {
        if($id != 1)
        {
            $user = User::find($id);
            if($user)
            {
                $user->delete();

                return new UserResource($user);
            }
            return response()->json(['errors' => [
                'status' => 404,
                'title'  => 'Not Found'
                ]
            ], 404);            
        }
        return response()->json([
            'message' => 'Unauthorized'
            ], 401);
    }

    public function activateUser($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user->trashed()) 
        {
            $user->restore();
            return response(null, 204); 
        }
        return response()->json(['errors' => [
            'status' => 404,
            'title'  => 'Not Found'
            ]
        ], 404);  
        
    }
}
