<?php

namespace App\Http\Controllers\V1;

use App\Models\Images;
use App\Http\Requests\V1\StoreImagesRequest;
use App\Http\Requests\V1\UpdateImagesRequest;
use App\Http\Resources\V1\ImagesResource;
use App\Traits\HttpResponses;

class ImagesController extends Controller
{
   use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImagesResource::collection(Images::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImagesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImagesRequest $request)
    {
         $request->validated($request->all());

         $images = Images::create($request->all());

         return $this->success($images, 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function show(Images $image)
    {
        return new ImagesResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImagesRequest  $request
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImagesRequest $request, Images $image)
    {
        $request->validated($request->all());

        if($request->filled('image_cover_url')) {
            $image->image_cover_url = $request->image_cover_url;
        }

        if($request->filled('image_url_1')) {
            $image->image_url_1 = $request->image_url_1;
        }

        if($request->filled('image_url_2')) {
            $image->image_url_2 = $request->image_url_2;
        }

        if($request->filled('image_url_3')) {
            $image->image_url_3 = $request->image_url_3;
        }
        
        if($request->filled('image_url_4')) {
            $image->image_url_4 = $request->image_url_4;
        }

        $image->save();

        return $image;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(Images $image)
    {
        $image->delete();
    }
}