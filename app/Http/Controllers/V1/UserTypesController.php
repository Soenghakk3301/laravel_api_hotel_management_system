<?php

namespace App\Http\Controllers\V1;

use App\Models\UserTypes;
use App\Http\Requests\V1\StoreUserTypesRequest;
use App\Http\Requests\V1\UpdateUserTypesRequest;
use App\Http\Resources\V1\UserTypesResource;
use App\Traits\HttpResponses;

class UserTypesController extends Controller
{

   use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->success(UserTypesResource::collection(UserTypes::all()), 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTypesRequest $request)
    {
        $request->validated($request->all());
        
        $usertype = UserTypes::create($request->all());

        return $this->success(new UserTypesResource($usertype), 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserTypes  $userTypes
     * @return \Illuminate\Http\Response
     */
    public function show(UserTypes $usertype)
    {
        return $this->success(new UserTypesResource($usertype), 'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserTypesRequest  $request
     * @param  \App\Models\UserTypes  $userTypes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTypesRequest $request, UserTypes $usertype)
    {
        $request->validated($request->all());

        if($request->filled('user_type_name')) {
           $usertype->user_type_name = $request->user_type_name;
        }

        $usertype->save();

        return $usertype;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserTypes  $userTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserTypes $usertype)
    {
      $usertype->delete();
    }
}