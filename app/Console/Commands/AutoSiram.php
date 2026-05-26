<?php

namespace App\Console\Commands;

use App\Models\Kontroller;
use Illuminate\Console\Command;

class AutoSiram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-siram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penyiraman otomatis terjadwal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // aktifkan mode manual
        Kontroller::query()->update([
            'mode_manual' => 1
        ]);

        $this->info('Pompa aktif');

        // tunggu 5 detik
        sleep(5);

        // matikan kembali
        Kontroller::query()->update([
            'mode_manual' => 0
        ]);

        $this->info('Pompa mati');

        return Command::SUCCESS;
    }
}
