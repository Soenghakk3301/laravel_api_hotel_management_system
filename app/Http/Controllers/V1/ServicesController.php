<?php

namespace App\Http\Controllers\V1;

use App\Models\Services;
use App\Http\Requests\V1\StoreServicesRequest;
use App\Http\Requests\V1\UpdateServicesRequest;
use App\Http\Resources\V1\ServicesResource;
use App\Traits\HttpResponses;

class ServicesController extends Controller
{
   use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ServicesResource::collection(Services::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesRequest $request)
    {
        $request->validated($request->all());

        $service = Services::create($request->all());

        return $this->success(new ServicesResource($service), 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $service)
    {
        return $this->success(new ServicesResource($service));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesRequest  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesRequest $request, Services $service)
    {
        $request->validated();

        if($request->filled('service_name')) {
            $service->service_name = $request->service_name;
        }

        $service->save();

        return $service;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $service)
    {
        $service->delete();
    }
}