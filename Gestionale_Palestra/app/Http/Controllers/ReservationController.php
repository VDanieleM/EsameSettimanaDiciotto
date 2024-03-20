<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Course;
use App\Http\Requests\StorereservationRequest;
use App\Http\Requests\UpdatereservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('user', 'course')->get();

        return view('admindashboard', ["reservations" => $reservations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reservation = new Reservation;
        $reservation->user_id = auth()->user()->id;
        $reservation->course_id = $request->course_id;
        $reservation->is_accepted = null;
        $reservation->save();

        return redirect()->route('dashboard')->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatereservationRequest $request, reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        // Check for correct user
        if(auth()->user()->id !== $reservation->user_id){
            return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }

        $reservation->delete();
        return redirect()->route('dashboard')->with('success', 'Reservation removed');
    }

    public function accept($id)
{
    $reservation = Reservation::find($id);
    if ($reservation) {
        $reservation->is_accepted = true;
        $reservation->save();
    }
    return redirect()->back();
}

public function reject($id)
{
    $reservation = Reservation::find($id);
    if ($reservation) {
        $reservation->is_accepted = false;
        $reservation->save();
    }
    return redirect()->back();
}
}

