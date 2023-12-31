<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {

        return inertia('Appointment/Index');
    }

    public function create()
    {
        return inertia('Appointment/Create', [
            'doctors' => Doctor::with('services', 'user')->get(),
        ]);
    }

    public function edit(Appointment $appointment)
    {
    return Inertia::render('Appointment/Edit', ['appointment' => $appointment]);
    }

    public function update(Request $request, Appointment $appointment)
    {
    $fields = $request->validate([
        'name' => 'required|string',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|date_format:H:i:s',
        'service_id' => 'required|string',
        'status' => 'required|string',
    ]);

    $appointment->update($fields);

    return redirect('/appointments')->with('info', 'Appointment Updated!.');
    }
    public function store(Request $request)
    {

        // dd($request);

       $fields = $request->validate([
            'name' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i:s',
            'service_id' => 'required|string',
            'status' => 'required|string',
            // 'patient' => 'required|string',
        ]);

        Appointment::create($fields);

        return redirect('/appointments');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect('/appointments')->with('info', 'Appointment Cancelled!.');
    }
}
