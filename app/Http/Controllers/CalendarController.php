<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Http\Resources\CalendarResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CalendarResource::collection(Calendar::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_calendar = Calendar::where('event_name', $request->event_name)->first();
        $status      = "";
        if($new_calendar){
            $new_calendar->event_name = $request->event_name;
            $new_calendar->start_date = $request->start_date;
            $new_calendar->end_date = $request->end_date;
            $new_calendar->week_day = serialize($request->week_day);
            $new_calendar->save();

            $status =  Response::HTTP_ACCEPTED;
        } else {
            $new_calendar = new Calendar();
            $new_calendar->event_name = $request->event_name;
            $new_calendar->start_date = $request->start_date;
            $new_calendar->end_date = $request->end_date;
            $new_calendar->week_day = serialize($request->week_day);
            $new_calendar->save();

            $status =  Response::HTTP_CREATED;
        }
      
        return response()->json([
            'data' => new CalendarResource($new_calendar),
            'message' => 'Successfully save event!',
            'status' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
