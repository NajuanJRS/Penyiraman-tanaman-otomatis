<?php

namespace Database\Seeders;

use App\Models\Prediksi as ModelsPrediksi;
use Illuminate\Database\Seeder;

class PrediksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPrediksi::create([
        'id_perkembangan' => 1,
        'decision' => 'Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 2,
            'decision' => 'Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 3,
            'decision' => 'Tidak Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 4,
            'decision' => 'Tidak Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 5,
            'decision' => 'Tidak Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 6,
            'decision' => 'Tidak Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 7,
            'decision' => 'Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 8,
            'decision' => 'Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 9,
            'decision' => 'Tidak Siram',
        ]);

        ModelsPrediksi::create([
            'id_perkembangan' => 10,
            'decision' => 'Tidak Siram',
        ]);

    }
}
