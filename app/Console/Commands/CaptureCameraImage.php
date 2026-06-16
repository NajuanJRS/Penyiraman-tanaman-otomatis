<?php

namespace App\Console\Commands;

use App\Models\Perkembangan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class CaptureCameraImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:capture-camera-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capture gambar kamera dan simpan ke data perkembangan terbaru';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $perkembangan = Perkembangan::latest('id_perkembangan')->first();

        if (! $perkembangan) {
            $this->error('Data perkembangan belum tersedia');

            return self::FAILURE;
        }

        $cameraRtsp = config('services.camera.rtsp');

        if (! $cameraRtsp) {
            $this->error('CAMERA_RTSP belum dikonfigurasi');

            return self::FAILURE;
        }

        $filename = Str::uuid().'.jpg';
        $tempPath = storage_path('app/temp_'.$filename);
        $imagePath = 'perkembangan/'.$filename;
        $finalPath = Storage::disk('public')->path($imagePath);

        Storage::disk('public')->makeDirectory('perkembangan');

        $command = sprintf(
            'ffmpeg -rtsp_transport tcp -i %s -frames:v 1 %s -y 2>&1',
            escapeshellarg($cameraRtsp),
            escapeshellarg($tempPath)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || ! file_exists($tempPath)) {
            @unlink($tempPath);
            $this->error('Capture gagal: '.implode(PHP_EOL, $output));

            return self::FAILURE;
        }

        try {
            Image::read($tempPath)
                ->scale(width: 1600)
                ->toJpeg(quality: 85)
                ->save($finalPath);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($imagePath);
            $this->error('Gagal memproses gambar: '.$exception->getMessage());

            return self::FAILURE;
        } finally {
            @unlink($tempPath);
        }

        $oldImage = $perkembangan->gambar;

        try {
            $perkembangan->gambar = $imagePath;
            $perkembangan->save();
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($imagePath);
            $this->error('Gagal memperbarui data perkembangan: '.$exception->getMessage());

            return self::FAILURE;
        }

        if ($oldImage && $oldImage !== $imagePath) {
            Storage::disk('public')->delete($oldImage);
        }

        $this->info(
            "Capture berhasil disimpan ke perkembangan ID {$perkembangan->id_perkembangan}"
        );

        return self::SUCCESS;
    }
}
