<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id', $event->id)
        ->first();

        if(!is_null($reservedPeople))
        {
            $reservablePeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            $reservablePeople = $event->max_people;
        }

        $isReserved = Reservation::where('user_id', '=', Auth::id())
        ->where('event_id', '=', $id)
        ->where('canceled_date', '=', null)
        ->latest()
        ->first();

        return view('event-detail', compact('event', 'reservablePeople', 'isReserved'));
    }

    public function reserve(Request $request)
    {
        //dd($request->reservedPeople);
        $event = Event::findOrFail($request->id);
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id', $request->id)
        ->first();
        //dd($reservedPeople); 

        if(is_null($reservedPeople) || 
        $event->max_people >= $reservedPeople->number_of_people + $request->reservedPeople)
        {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request->id,
                'number_of_people' => $request->reservedPeople,
            ]);

            session()->flash('status', '登録OKです');
            return to_route('dashboard');

        } else {
            session()->flash('status', 'この人数は予約できません');
            return view('dashboard');
        }
    }
}
