<?php

namespace Database\Seeders;

use App\Models\Perkembangan as ModelsPerkembangan;
use Illuminate\Database\Seeder;

class PerkembanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPerkembangan::create([
        'waktu' => '2026-04-01 00:00:00',
        'kelembapan_tanah' => 58.20,
        'kelembapan_udara' => 72.10,
        'suhu' => 26.50,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-01 04:00:00',
            'kelembapan_tanah' => 60.45,
            'kelembapan_udara' => 73.30,
            'suhu' => 25.90,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-01 08:00:00',
            'kelembapan_tanah' => 64.10,
            'kelembapan_udara' => 75.20,
            'suhu' => 27.10,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-01 12:00:00',
            'kelembapan_tanah' => 69.30,
            'kelembapan_udara' => 68.50,
            'suhu' => 30.20,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-01 16:00:00',
            'kelembapan_tanah' => 71.80,
            'kelembapan_udara' => 66.40,
            'suhu' => 29.70,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-01 20:00:00',
            'kelembapan_tanah' => 68.55,
            'kelembapan_udara' => 71.90,
            'suhu' => 27.40,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-02 00:00:00',
            'kelembapan_tanah' => 59.20,
            'kelembapan_udara' => 73.50,
            'suhu' => 26.10,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-02 04:00:00',
            'kelembapan_tanah' => 57.10,
            'kelembapan_udara' => 74.00,
            'suhu' => 25.80,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-02 08:00:00',
            'kelembapan_tanah' => 63.90,
            'kelembapan_udara' => 76.20,
            'suhu' => 27.50,
        ]);

        ModelsPerkembangan::create([
            'waktu' => '2026-04-02 12:00:00',
            'kelembapan_tanah' => 66.40,
            'kelembapan_udara' => 69.80,
            'suhu' => 30.10,
        ]);

    }
}
