<?php

namespace App\Http\Controllers\V1;

use App\Filters\RoomFilter;
use App\Models\Rooms;
use App\Http\Requests\V1\StoreRoomsRequest;
use App\Http\Requests\V1\UpdateRoomsRequest;
use App\Http\Resources\V1\RoomResource;
use App\Models\RoomTypes;
use App\Services\AvailabilityChecker;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;


class RoomsController extends Controller
{

   use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      // create new instance of roomFilter
      $filter = new RoomFilter();
      $query = $filter->transform($request);


      $rooms = Rooms::join('room_types', 'rooms.room_types_id', '=', 'room_types.id')
                 ->select('rooms.*', 'room_types.name', 'room_types.bed_type', 'room_types.price', 'room_types.room_size', 'room_types.floor', 'room_types.num_guest');

      if($request->checkIn && $request->checkOut)
         $unavailableRooms = AvailabilityChecker::getUnavailableRoomsForDateRange($request->checkIn, $request->checkOut);
      // $unavailableRooms = [1, 2];

      // $rooms = $rooms->where($query)->get();
      $rooms = $rooms->where($query);

      // $rooms = $rooms->where($query);

      
      // change values of rooms that are unavailables
      if($request->checkIn && $request->checkOut){
            foreach($rooms as &$room) 
               if(in_array($room['id'], $unavailableRooms))
                  $room['is_available'] = false;
      }
      
      $rooms = $rooms->where($query);
      return RoomResource::collection($rooms->paginate(10)->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomsRequest $request)
    {
        $request->validated($request->all());

        $room = Rooms::create($request->all());

        return $this->success(new RoomResource($room), 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show(Rooms $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomsRequest  $request
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomsRequest $request, Rooms $room)
    {
        if($request->filled('room_no')) {
            $room->room_no = $request->room_no;
        }

        $room->save();

        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rooms $room)
    {
        $room->delete();
    }
}