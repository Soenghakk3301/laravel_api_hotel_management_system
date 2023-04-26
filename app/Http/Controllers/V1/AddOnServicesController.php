<?php

namespace App\Http\Controllers\V1;

use App\Models\AddOnServices;
use App\Http\Requests\V1\StoreAddOnServicesRequest;
use App\Http\Requests\V1\UpdateAddOnServicesRequest;
use App\Http\Resources\V1\AddOnServicesResource;
use App\Traits\HttpResponses;

class AddOnServicesController extends Controller
{

   use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AddOnServices::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddOnServicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddOnServicesRequest $request)
    {
        $request->validated($request->all());

        $addonservice = AddOnServices::create($request->all());

        return $this->success(new AddOnServicesResource($addonservice), 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddOnServices  $add_service_roomtype
     * @return \Illuminate\Http\Response
     */
    public function show(AddOnServices $add_service_roomtype)
    {
        return new AddOnServicesResource($add_service_roomtype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddOnServicesRequest  $request
     * @param  \App\Models\AddOnServices  $add_service_roomtype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddOnServicesRequest $request, AddOnServices $add_service_roomtype)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddOnServices  $add_service_roomtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddOnServices $add_service_roomtype)
    {
        $add_service_roomtype->delete();
    }
}