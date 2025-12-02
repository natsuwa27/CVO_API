<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Block;
class CalendarController extends Controller
{
      /**
     * Mostrar todos los calendarios o filtrar por fecha.
     * GET /api/calendars
     * GET /api/calendars?date=2025-12-01
     */
    public function index(Request $request)
    {
        $date = $request->query('date');

        $query = Calendar::with('blocks');

        if ($date) {
            $query->where('date', $date);
        }

        return response()->json([
            'status' => 200,
            'data'   => $query->get(),
        ], 200);
    }

    /**
     * Crear un calendario.
     * POST /api/calendars
     */
    public function store(Request $request)
    {
        $request->validate([
            'admin_id'   => 'nullable|integer',
            'date'       => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time'   => 'nullable|date_format:H:i',
        ]);

        $calendar = Calendar::create($request->all());

        return response()->json([
            'status'  => 201,
            'message' => 'Calendario creado correctamente',
            'data'    => $calendar,
        ], 201);
    }

    /**
     * Agregar un bloque a un calendario.
     * POST /api/calendars/{calendar}/blocks
     */
    public function addBlock(Request $request, $calendarId)
    {
        $request->validate([
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i',
            'is_available' => 'boolean',
        ]);

        $calendar = Calendar::findOrFail($calendarId);

        $block = Block::create([
            'calendar_id' => $calendar->id,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'is_available'=> $request->input('is_available', true),
        ]);

        return response()->json([
            'status'  => 201,
            'message' => 'Bloque creado correctamente',
            'data'    => $block,
        ], 201);
    }

    /**
     * Actualizar un bloque.
     * PUT /api/blocks/{block}
     */
    public function updateBlock(Request $request, $blockId)
    {
        $request->validate([
            'start_time'   => 'sometimes|date_format:H:i',
            'end_time'     => 'sometimes|date_format:H:i',
            'is_available' => 'sometimes|boolean',
        ]);

        $block = Block::findOrFail($blockId);
        $block->update($request->all());

        return response()->json([
            'status'  => 200,
            'message' => 'Bloque actualizado correctamente',
            'data'    => $block,
        ], 200);
    }

    /**
     * Eliminar un bloque.
     * DELETE /api/blocks/{block}
     */
    public function destroyBlock($blockId)
    {
        $block = Block::findOrFail($blockId);
        $block->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Bloque eliminado correctamente',
        ], 200);
    }
}
