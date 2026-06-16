@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <span class="page-kicker">
                <i class="bi bi-sliders"></i>
                Kontrol
            </span>
            <h3>Kontrol Penyiraman</h3>
            <p>Atur mode pompa air dan batas kelembapan tanah untuk keputusan penyiraman.</p>
        </div>
        <div class="page-header-icon">
            <i class="bi bi-droplet-half"></i>
        </div>
    </div>

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

    <form id="formOtomatis" method="POST" action="{{ route('kontrol.otomatis') }}">
        @csrf
    </form>

    <form id="formManual" method="POST" action="{{ route('kontrol.manual') }}">
        @csrf
    </form>

    <form id="formOff" method="POST" action="{{ route('kontrol.off') }}">
        @csrf
    </form>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="control-card {{ $mode_otomatis == 1 ? 'active' : '' }}">
                <div class="control-top">
                    <div class="control-icon auto">
                        <i class="bi {{ $mode_otomatis == 1 ? 'bi-droplet-fill' : 'bi-droplet' }}"></i>
                    </div>
                    <span class="status-pill {{ $mode_otomatis == 1 ? 'on' : 'off' }}">
                        {{ $mode_otomatis == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <h4>Mode Otomatis</h4>
                <p>Sistem menyiram berdasarkan pembacaan sensor dan batas kelembapan yang ditentukan.</p>

                <div class="control-meta">
                    <span>
                        <i class="bi bi-cpu"></i>
                        Sensor driven
                    </span>
                    <span>
                        <i class="bi bi-lightning-charge"></i>
                        Respons otomatis
                    </span>
                </div>

                @if ($mode_otomatis == 1)
                    <button class="btn btn-soft-danger" onclick="confirmMode('off')">
                        <i class="bi bi-stop-circle"></i>
                        Matikan
                    </button>
                @else
                    <button class="btn btn-garden" onclick="confirmMode('otomatis')">
                        <i class="bi bi-play-circle"></i>
                        Aktifkan
                    </button>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="control-card {{ $mode_manual == 1 ? 'active' : '' }}">
                <div class="control-top">
                    <div class="control-icon manual">
                        <i class="bi bi-hand-index-thumb"></i>
                    </div>
                    <span class="status-pill {{ $mode_manual == 1 ? 'on' : 'off' }}">
                        {{ $mode_manual == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <h4>Mode Manual</h4>
                <p>Pompa dijalankan sesuai perintah pengguna melalui tombol kontrol di dashboard.</p>

                <div class="control-meta">
                    <span>
                        <i class="bi bi-person-check"></i>
                        Kendali langsung
                    </span>
                    <span>
                        <i class="bi bi-water"></i>
                        Penyiraman cepat
                    </span>
                </div>

                @if ($mode_manual == 1)
                    <button class="btn btn-soft-danger" onclick="confirmMode('off')">
                        <i class="bi bi-stop-circle"></i>
                        Matikan
                    </button>
                @else
                    <button class="btn btn-sky" onclick="confirmMode('manual')">
                        <i class="bi bi-hand-index-thumb"></i>
                        Aktifkan
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="settings-panel mt-4">
        <div class="section-title">
            <div>
                <h5>Pengaturan Keputusan Penyiraman</h5>
                <p>Sesuaikan ambang batas agar rekomendasi sistem sesuai kondisi tanaman.</p>
            </div>
            <i class="bi bi-toggles2"></i>
        </div>

        <form id="thresholdForm" action="{{ route('kontrol.threshold') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5 col-lg-4">
                    <label class="form-label fw-bold">
                        Siram jika kelembapan tanah ≤
                    </label>
                    <div class="input-group modern-input">
                        <input type="number" class="form-control" name="batas_kelembapan" min="0" max="100"
                            value="{{ $batas_kelembapan }}">
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <button type="button" class="btn btn-garden" onclick="confirmSaveKelembapan()">
                        <i class="bi bi-check-circle"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>

            <div class="info-strip mt-4">
                <i class="bi bi-info-circle"></i>
                <span>
                    Saat ini sistem akan menghasilkan <strong>Siram</strong> jika kelembapan tanah berada di bawah
                    atau sama dengan <strong>{{ $batas_kelembapan }}%</strong>.
                </span>
            </div>
        </form>
    </div>
@endsection
