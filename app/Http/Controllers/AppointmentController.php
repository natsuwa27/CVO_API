<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
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
}