@extends('layouts.app')

@section('content')
    <h3>Kontrol Manual dan Otomatis</h3>
    <p>Kendalikan Pompa Air secara manual dan otomatis</p>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    <div class="row">

        <!-- Form tetap dipertahankan -->
        <form id="formOtomatis" method="POST" action="{{ route('kontrol.otomatis') }}">
            @csrf
        </form>

        <form id="formManual" method="POST" action="{{ route('kontrol.manual') }}">
            @csrf
        </form>

        <form id="formOff" method="POST" action="{{ route('kontrol.off') }}">
            @csrf
        </form>

        <!-- Mode Otomatis -->
        <div class="col-md-6">

            <div class="card-box text-center p-4 h-100">

                <h4 class="mb-3">
                    Mode Penyiraman Otomatis
                </h4>

                @if ($mode_otomatis == 1)
                    <i class="bi bi-droplet-fill text-success" style="font-size:70px"></i>

                    <div class="mt-2">
                        <span class="badge bg-success px-3 py-2">
                            Aktif
                        </span>
                    </div>
                @else
                    <i class="bi bi-droplet text-secondary" style="font-size:70px"></i>

                    <div class="mt-2">
                        <span class="badge bg-danger px-3 py-2">
                            Nonaktif
                        </span>
                    </div>
                @endif

                <p class="text-muted mt-3 mb-4">
                    Sistem akan menyiram secara otomatis
                    berdasarkan kondisi sensor.
                </p>

                @if ($mode_otomatis == 1)
                    <button class="btn btn-outline-danger" onclick="confirmMode('off')">

                        <i class="bi bi-stop-circle"></i>
                        Matikan

                    </button>
                @else
                    <button class="btn btn-success" onclick="confirmMode('otomatis')">

                        <i class="bi bi-play-circle"></i>
                        Aktifkan

                    </button>
                @endif

            </div>

        </div>

        <!-- Mode Manual -->
        <div class="col-md-6">

            <div class="card-box text-center p-4 h-100">

                <h4 class="mb-3">
                    Mode Penyiraman Manual
                </h4>

                @if ($mode_manual == 1)
                    <i class="bi bi-water text-primary" style="font-size:70px"></i>

                    <div class="mt-2">
                        <span class="badge bg-success px-3 py-2">
                            Aktif
                        </span>
                    </div>
                @else
                    <i class="bi bi-water text-secondary" style="font-size:70px"></i>

                    <div class="mt-2">
                        <span class="badge bg-danger px-3 py-2">
                            Nonaktif
                        </span>
                    </div>
                @endif

                <p class="text-muted mt-3 mb-4">
                    Penyiraman dijalankan secara manual
                    melalui tombol kontrol.
                </p>

                @if ($mode_manual == 1)
                    <button class="btn btn-outline-danger" onclick="confirmMode('off')">

                        <i class="bi bi-stop-circle"></i>
                        Matikan

                    </button>
                @else
                    <button class="btn btn-primary" onclick="confirmMode('manual')">

                        <i class="bi bi-hand-index-thumb"></i>
                        Aktifkan

                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-box mt-4">

        <h4 class="mb-4">
            <i class="bi bi-sliders"></i>
            Pengaturan Keputusan Penyiraman
        </h4>

        <form id="thresholdForm" action="{{ route('kontrol.threshold') }}" method="POST">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">
                        Siram jika kelembapan tanah ≤
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="batas_kelembapan" min="0" max="100"
                            value="{{ $batas_kelembapan }}">
                        <span class="input-group-text">
                            %
                        </span>
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-success" onclick="confirmSaveKelembapan()">
                        <i class="bi bi-check-circle"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>

            <div class="alert alert-info mt-4 mb-0">

                <i class="bi bi-info-circle"></i>

                Saat ini sistem akan menghasilkan
                <strong>Siram</strong>
                jika kelembapan tanah berada di bawah atau sama dengan

                <strong>{{ $batas_kelembapan }}%</strong>

            </div>

        </form>
    </div>
@endsection
