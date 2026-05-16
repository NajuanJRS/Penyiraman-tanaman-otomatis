<?php

namespace Database\Seeders;

use App\Models\Kontroller as ModelsKontroller;
use Illuminate\Database\Seeder;

class KontrollerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ModelsKontroller::create([
        'mode_otomatis' => true,
        'mode_manual' => false,
        ]); 
    }
}
