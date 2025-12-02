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
                'service_id' => 1,
                'active'       => true,
            ],
            [
                'client_id'    => 2,
                'pet_id'       => 3,
                'date'         => now()->addDays(5),
                'reason'       => 'Vaccination booster',
                'service_id' => 2,
                'active'       => true,
            ],
            [
                'client_id'    => 1,
                'pet_id'       => 2,
                'date'         => now()->addDays(10),
                'reason'       => 'Surgery follow-up',
                'service_id' => 3,
                'active'       => true,
            ],
        ]);
    }
}