<?php

namespace App\Http\Controllers\V1;

use App\Filters\RoomTypeFilter;
use App\Models\RoomTypes;
use App\Http\Requests\V1\StoreRoomTypesRequest;
use App\Http\Requests\V1\UpdateRoomTypesRequest;
use App\Http\Resources\V1\RoomTypesResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class RoomTypesController extends Controller
{
   use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
         $filter = new RoomTypeFilter();
         $filterItems = $filter->transform($request);

         // dd($filterItems);

         $includeImages = $request->query('includeImages');

         $roomtypes = RoomTypes::where($filterItems);

         if($includeImages)
            $roomtypes = $roomtypes->with('image');
         
         return RoomTypesResource::collection($roomtypes->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomTypesRequest $request)
    {
        /**
         * check if the in-coming data is correct
         */
        $request->validated($request->all());

        $room_type = RoomTypes::create($request->all());

      
        return $this->success(new RoomTypesResource($room_type), 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function show(RoomTypes $roomtype)
    {
        $includeImages = request()->query('includeImages');

        if($includeImages) return new RoomTypesResource($roomtype->loadMissing('image'));

        return new RoomTypesResource($roomtype);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomTypesRequest  $request
     * @param  \App\Models\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomTypesRequest $request, RoomTypes $roomtype)
    {
         if($request->filled('name')) {
               $roomtype->name = $request->name;
         }
            
         if($request->filled('main_description')) {
            $roomtype->main_description = $request->main_description;
         }
            
         if($request->filled('sub_description')) {
            $roomtype->sub_description = $request->sub_description;
         }

         if($request->filled('bed_type')) {
            $roomtype->bed_type = $request->bed_type;
         }

         if($request->filled('price')) {
            $roomtype->price = $request->price;
         }

         if($request->filled('room_size')) {
            $roomtype->room_size = $request->room_size;
         }

         if($request->filled('num_guest')) {
            $roomtype->num_guest = $request->num_guest;
         }

         $roomtype->save();

         return $roomtype;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomTypes $roomtype)
    { 
         $roomtype->delete();  
    }
}