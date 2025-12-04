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
        if ($block->calendar->date->lt(now()->startOfDay())) {
            return back()->with('error', 'No puedes reservar en una fecha pasada.');
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

        if ($appointment->active === false) {
            return redirect()->route('appointments.index')
                    ->with('error', 'No puedes editar una cita cancelada.');
        }

        $pets = Pet::where('owner_id', Auth::id())->get();
        $services = Service::where('active', true)->get();

        $blocks = Block::with('calendar')
            ->where(function ($q) {
                $q->where('is_active', true)
                  ->where('is_booked', false)
                  ->whereHas('calendar', function ($c) {
                      $c->where('is_open', true)
                        ->whereDate('date', '>=', now()->toDateString());
                  });
            })
            ->orWhere('id', $appointment->block_id)
            ->orderBy('calendar_id')
            ->orderBy('start_time')
            ->get();

        if ($blocks->isEmpty()) {
            return redirect()->route('appointments.index')
                         ->with('error', 'No hay bloques disponibles para editar la cita.');
        }

        return view('appointments.edit', compact('appointment', 'pets', 'services', 'blocks'));
    }

    public function updateWeb(Request $request, $id)
    {
        $appointment = Appointment::where('client_id', Auth::id())->findOrFail($id);

        if ($appointment->active === false) {
            return redirect()->route('appointments.index')
                    ->with('error', 'No puedes editar una cita cancelada.');
        }

        $data = $request->validate([
            'pet_id'     => 'sometimes|exists:pets,id',
            'service_id' => 'sometimes|exists:services,id',
            'reason'     => 'sometimes|string|max:255',
            'block_id'   => 'sometimes|exists:blocks,id',
        ]);

        if (isset($data['pet_id']))     $appointment->pet_id = $data['pet_id'];
        if (isset($data['service_id'])) $appointment->service_id = $data['service_id'];
        if (isset($data['reason']))     $appointment->reason = $data['reason'];

        $newBlockId = $data['block_id'] ?? $appointment->block_id;

        if ($newBlockId != $appointment->block_id) {
            $newBlock = Block::with('calendar')->findOrFail($newBlockId);

            if (! $newBlock->is_active || $newBlock->is_booked || ! $newBlock->calendar->is_open) {
                return back()->with('error', 'El nuevo horario seleccionado no está disponible.');
            }
            if ($newBlock->calendar->date->lt(now()->startOfDay())) {
                return back()->with('error', 'No puedes mover la cita a una fecha pasada.');
            }

            $oldBlock = Block::find($appointment->block_id);
            if ($oldBlock) {
                $oldBlock->is_booked = false;
                $oldBlock->save();
            }

            $appointment->block_id = $newBlock->id;
            $appointment->date     = $newBlock->calendar->date->format('Y-m-d').' '.$newBlock->start_time;

            $newBlock->is_booked = true;
            $newBlock->save();
        }

        $appointment->save();

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