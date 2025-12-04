<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Calendar;
use App\Models\CalendarSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();
        $calendars = Calendar::whereBetween('date', [
                $startOfMonth->toDateString(),
                $endOfMonth->toDateString(),
            ])
            ->orderBy('date')
            ->get()
            ->keyBy(fn (Calendar $calendar) => $calendar->date->format('Y-m-d'));

        return view('admin.calendar.index', [
            'year'         => $year,
            'month'        => $month,
            'startOfMonth' => $startOfMonth,
            'endOfMonth'   => $endOfMonth,
            'calendars'    => $calendars,
        ]);
    }

    public function generateMonth(Request $request)
    {
        $data = $request->validate([
            'year'  => ['required', 'integer', 'min:2000', 'max:2100'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $year  = (int) $data['year'];
        $month = (int) $data['month'];

        $settings = CalendarSetting::where('is_active', true)->first();

        if (! $settings) {
            $settings = CalendarSetting::create([
                'block_duration' => 30,
                'start_time'     => '08:00:00',
                'end_time'       => '18:00:00',
                'working_days'   => 'mon,tue,wed,thu,fri',
                'is_active'      => true,
            ]);
        }

        $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $workingDays  = $settings->working_days_array; // ['mon','tue',...]

        DB::transaction(function () use ($startOfMonth, $endOfMonth, $workingDays, $settings) {

            Calendar::whereBetween('date', [
                    $startOfMonth->toDateString(),
                    $endOfMonth->toDateString(),
                ])
                ->whereDate('date', '>=', now()->toDateString())
                ->delete();

            $currentDay = $startOfMonth->copy();

            while ($currentDay->lte($endOfMonth)) {

                $dayOfWeek = strtolower($currentDay->format('D')); // mon, tue, ...

                $isWorkingDay    = in_array($dayOfWeek, $workingDays, true);
                $isFutureOrToday = $currentDay->gte(now()->startOfDay());

                $isOpen = $isWorkingDay && $isFutureOrToday;

                $calendar = Calendar::create([
                    'date'       => $currentDay->toDateString(),
                    'is_open'    => $isOpen,
                    'is_special' => false,
                    'start_time' => $settings->start_time,
                    'end_time'   => $settings->end_time,
                ]);

                if ($isOpen) {
                    $this->generateBlocksForDay($calendar, (int) $settings->block_duration);
                }
                $currentDay->addDay();
            }
        });

        return back()->with('success', 'Calendario del mes generado correctamente.');
    }

    private function generateBlocksForDay(Calendar $calendar, int $blockDuration): void
    {
        if (empty($calendar->start_time) || empty($calendar->end_time)) {
            return;
        }

        $start = Carbon::parse($calendar->date->toDateString().' '.$calendar->start_time);
        $end   = Carbon::parse($calendar->date->toDateString().' '.$calendar->end_time);

        while ($start->lt($end)) {
            $slotStart = $start->copy();
            $slotEnd   = $start->copy()->addMinutes($blockDuration);

            if ($slotEnd->gt($end)) {
                break;
            }

            Block::create([
                'calendar_id' => $calendar->id,
                'start_time'  => $slotStart->format('H:i:s'),
                'end_time'    => $slotEnd->format('H:i:s'),
                'is_active'   => true,
                'is_booked'   => false,
            ]);

            $start->addMinutes($blockDuration);
        }
    }

    public function show(Calendar $calendar)
    {
        $calendar->load(['blocks' => function ($query) {
            $query->orderBy('start_time');
        }]);

         return view('admin.calendar.show', compact('calendar'));
    }

    public function closeDay(Calendar $calendar)
{
    $today = Carbon::today();

    if ($calendar->date->lt($today)) {
        return back()->with('error', 'No puedes modificar un día que ya pasó.');
    }

    $weekday = $calendar->date->dayOfWeekIso;

    if ($weekday >= 6 && ! $calendar->is_open) {
        return back()->with('error', 'Este día es fin de semana y no está configurado como día laboral. No puede reabrirse.');
    }

    if ($calendar->is_open) {
        DB::transaction(function () use ($calendar) {
            $calendar->update([
                'is_open' => false,
            ]);

            $calendar->blocks()->update([
                'is_active' => false,
            ]);
        });

        return back()->with('success', 'El día se cerró correctamente y se desactivaron todos los bloques.');
    } else {
        DB::transaction(function () use ($calendar) {
            $calendar->update([
                'is_open' => true,
            ]);

            $calendar->blocks()->update([
                'is_active' => true,
            ]);
        });

        return back()->with('success', 'El día se reabrió correctamente y se activaron todos los bloques.');
    }
}

    public function toggleBlock(Block $block)
    {
       $calendar = $block->calendar; // gracias a la relación

    if (! $calendar) {
        return back()->with('error', 'No se encontró el día asociado a este bloque.');
    }

    $today = Carbon::today();

    if ($calendar->date->lt($today)) {
        return back()->with('error', 'No puedes modificar bloques de un día que ya pasó.');
    }

    if (! $calendar->is_open) {
        return back()->with('error', 'No puedes modificar bloques de un día cerrado.');
    }

    $block->update([
        'is_active' => ! $block->is_active,
    ]);

    return back()->with(
        'success',
        $block->is_active
            ? 'Bloque activado correctamente.'
            : 'Bloque desactivado correctamente.'
    );
    }
}
