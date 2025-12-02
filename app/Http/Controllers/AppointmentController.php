<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'pet_id'       => 'required|exists:pets,id',
            'date'         => 'required|date',
            'service_type' => 'required|in:consultation,vaccination,surgery,grooming',
            'reason'       => 'required|string|max:255',
            'active'       => 'sometimes|boolean',
        ]);

        $data['client_id'] = Auth::id();
        $data['active'] = $data['active'] ?? true;

        $appointment = Appointment::create($data)->load(['client','pet']);

        return response()->json([
            'message' => "Appointment created: Client {$appointment->client->name}, Pet {$appointment->pet->name}, Date {$appointment->date}, Service {$appointment->service_type}, Reason {$appointment->reason}",
            'appointment' => $appointment
        ], 201);
    }

    public function read($id)
    {
        $appointment = Appointment::with(['client','pet'])
            ->where('client_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'message' => "Appointment details: Client {$appointment->client->name}, Pet {$appointment->pet->name}, Date {$appointment->date}, Service {$appointment->service_type}, Reason {$appointment->reason}",
            'appointment' => $appointment
        ]);
    }

    public function myAppointments()
    {
        $appointments = Appointment::with(['client','pet'])
            ->where('client_id', Auth::id())
            ->get();

        return response()->json([
            'message' => "List of your appointments",
            'appointments' => $appointments
        ]);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'date'         => 'sometimes|date',
            'service_type' => 'sometimes|in:consultation,vaccination,surgery,grooming',
            'reason'       => 'sometimes|string|max:255',
            'active'       => 'sometimes|boolean',
        ]);

        $appointment->update($data);
        $appointment->load(['client','pet']);

        return response()->json([
            'message' => "Appointment updated: Client {$appointment->client->name}, Pet {$appointment->pet->name}, New date {$appointment->date}, Service {$appointment->service_type}, Reason {$appointment->reason}",
            'appointment' => $appointment
        ]);
    }

    public function delete($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);
        $appointment->reason = 'Cancelled appointment';
        $appointment->active = false;
        $appointment->save();

        return response()->json([
            'message' => "Appointment cancelled: ID {$appointment->id}, Client {$appointment->client->name}, Pet {$appointment->pet->name}, Date {$appointment->date}",
            'appointment' => $appointment
        ]);
    }



    public function index()
    {
        $appointments = Appointment::with(['client','pet','service'])
            ->where('client_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function createForm()
    {
        $pets = Pet::where('owner_id', Auth::id())->get();
        $services = Service::where('active', true)->get();

        return view('appointments.create', compact('pets','services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pet_id'     => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date',
            'reason'     => 'required|string|max:255',
        ]);

        $data['client_id'] = Auth::id();
        $data['active'] = true;

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'La Cita ha sido creada correctamente');
    }

    public function show($id)
    {
        $appointment = Appointment::with(['client','pet','service'])
            ->where('client_id', Auth::id())
            ->findOrFail($id);

        return view('appointments.show', compact('appointment'));
    }

    public function editForm($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);
        $pets = Pet::where('owner_id', Auth::id())->get();
        $services = Service::where('active', true)->get();

        return view('appointments.edit', compact('appointment','pets','services'));
    }

    public function updateWeb(Request $request, $id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'pet_id'     => 'sometimes|exists:pets,id',
            'service_id' => 'sometimes|exists:services,id',
            'date'       => 'sometimes|date',
            'reason'     => 'sometimes|string|max:255',
        ]);

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'La Cita ha sido actualizada correctamente');
    }

    public function deleteWeb($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);
        $appointment->update(['active' => false, 'reason' => 'Cancelled appointment']);

        return redirect()->route('appointments.index')->with('success', 'La Cita ha sido cancelada');
    }

}