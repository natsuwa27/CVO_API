<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /** ------------------ API ------------------ **/

    public function create(Request $request)
    {
        $data = $request->validate([
            'pet_id'     => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'block_id'   => 'required|exists:blocks,id',
            'reason'     => 'required|string|max:255',
            'active'     => 'sometimes|boolean',
        ]);

        $block = Block::with('calendar')->findOrFail($data['block_id']);

        if (! $block->is_active || $block->is_booked || ! $block->calendar->is_open) {
            return response()->json(['error' => 'El horario seleccionado no está disponible.'], 422);
        }

        $appointment = Appointment::create([
            'client_id'  => Auth::id(),
            'pet_id'     => $data['pet_id'],
            'service_id' => $data['service_id'],
            'block_id'   => $block->id,
            'date'       => $block->calendar->date->format('Y-m-d').' '.$block->start_time,
            'reason'     => $data['reason'],
            'active'     => $data['active'] ?? true,
        ]);

        $block->update(['is_booked' => true]);

        return response()->json([
            'message' => "Appointment created successfully",
            'appointment' => $appointment->load(['client','pet','service'])
        ], 201);
    }

    public function read($id)
    {
        $appointment = Appointment::with(['client','pet','service','block.calendar'])
            ->where('client_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'message' => "Appointment details",
            'appointment' => $appointment
        ]);
    }

    public function myAppointments()
    {
        $appointments = Appointment::with(['client','pet','service','block.calendar'])
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
            'reason' => 'sometimes|string|max:255',
            'active' => 'sometimes|boolean',
        ]);

        $appointment->update($data);

        return response()->json([
            'message' => "Appointment updated",
            'appointment' => $appointment->load(['client','pet','service'])
        ]);
    }

    public function delete($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);

        if ($appointment->block_id) {
            $block = Block::find($appointment->block_id);
            if ($block) {
                $block->update(['is_booked' => false]);
            }
        }

        $appointment->update([
            'reason' => 'Cancelled appointment',
            'active' => false,
        ]);

        return response()->json([
            'message' => "Appointment cancelled",
            'appointment' => $appointment
        ]);
    }

    /** ------------------ WEB ------------------ **/

    public function index()
    {
        $appointments = Appointment::with(['client','pet','service','block.calendar'])
            ->where('client_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function createForm()
    {
        $pets = Pet::where('owner_id', Auth::id())->get();
        $services = Service::where('active', true)->get();

        $blocks = Block::where('is_active', true)
            ->where('is_booked', false)
            ->whereHas('calendar', function ($q) {
                $q->where('is_open', true)
                  ->whereDate('date', '>=', now()->toDateString());
            })
            ->orderBy('calendar_id')
            ->orderBy('start_time')
            ->with('calendar')
            ->get();

        return view('appointments.create', compact('pets','services','blocks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pet_id'     => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'block_id'   => 'required|exists:blocks,id',
            'reason'     => 'required|string|max:255',
        ]);

        $block = Block::with('calendar')->findOrFail($data['block_id']);

        if (! $block->is_active || $block->is_booked || ! $block->calendar->is_open) {
            return back()->with('error', 'El horario seleccionado no está disponible.');
        }

        $appointment = Appointment::create([
            'client_id'  => Auth::id(),
            'pet_id'     => $data['pet_id'],
            'service_id' => $data['service_id'],
            'block_id'   => $block->id,
            'date'       => $block->calendar->date->format('Y-m-d').' '.$block->start_time,
            'reason'     => $data['reason'],
            'active'     => true,
        ]);

        $block->update(['is_booked' => true]);

        return redirect()->route('appointments.index')->with('success', 'La cita ha sido creada correctamente');
    }

    public function show($id)
    {
        $appointment = Appointment::with(['client','pet','service','block.calendar'])
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
            'reason'     => 'sometimes|string|max:255',
        ]);

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'La Cita ha sido actualizada correctamente');
    }

    public function deleteWeb($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);

        if ($appointment->block_id) {
            $block = Block::find($appointment->block_id);
            if ($block) {
                $block->update(['is_booked' => false]);
            }
        }

        $appointment->update(['active' => false, 'reason' => 'Cancelled appointment']);

        return redirect()->route('appointments.index')->with('success', 'La Cita ha sido cancelada');
    }
}