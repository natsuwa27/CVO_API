<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::insert([
            [
                'client_id'    => 1,
                'pet_id'       => 1, 
                'date'         => now()->addDays(2),
                'reason'       => 'General checkup',
                'service_type' => 'consultation',
                'active'       => true,
            ],
            [
                'client_id'    => 2,
                'pet_id'       => 3,
                'date'         => now()->addDays(5),
                'reason'       => 'Vaccination booster',
                'service_type' => 'vaccination',
                'active'       => true,
            ],
            [
                'client_id'    => 1,
                'pet_id'       => 2,
                'date'         => now()->addDays(10),
                'reason'       => 'Surgery follow-up',
                'service_type' => 'surgery',
                'active'       => true,
            ],
        ]);
    }
}