@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h3>Kontrol Penyiraman</h3>
        <p>Pilih mode pompa dan atur batas kelembapan untuk keputusan penyiraman.</p>
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

    {{-- Hidden forms --}}
    <form id="formOtomatis" method="POST" action="{{ route('kontrol.otomatis') }}">@csrf</form>
    <form id="formManual"   method="POST" action="{{ route('kontrol.manual') }}">@csrf</form>
    <form id="formOff"      method="POST" action="{{ route('kontrol.off') }}">@csrf</form>

    {{-- Mode cards --}}
    <div class="row g-3 mb-4">

        {{-- Otomatis --}}
        <div class="col-md-6">
            <div class="mode-card {{ $mode_otomatis == 1 ? 'mode-card--active' : '' }}">
                <div class="mode-card__head">
                    <div class="mode-card__icon mode-card__icon--green">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <span class="mode-badge {{ $mode_otomatis == 1 ? 'mode-badge--on' : 'mode-badge--off' }}">
                        {{ $mode_otomatis == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <h4 class="mode-card__title">Mode Otomatis</h4>
                <p class="mode-card__desc">Pompa menyiram secara otomatis berdasarkan pembacaan sensor kelembapan tanah.</p>

                <div class="mode-card__footer">
                    @if ($mode_otomatis == 1)
                        <button class="btn btn-soft-danger" onclick="confirmMode('off')">
                            <i class="bi bi-stop-circle"></i> Matikan
                        </button>
                    @else
                        <button class="btn btn-garden" onclick="confirmMode('otomatis')">
                            <i class="bi bi-play-circle"></i> Aktifkan
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Manual --}}
        <div class="col-md-6">
            <div class="mode-card {{ $mode_manual == 1 ? 'mode-card--active' : '' }}">
                <div class="mode-card__head">
                    <div class="mode-card__icon mode-card__icon--blue">
                        <i class="bi bi-hand-index-thumb"></i>
                    </div>
                    <span class="mode-badge {{ $mode_manual == 1 ? 'mode-badge--on' : 'mode-badge--off' }}">
                        {{ $mode_manual == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <h4 class="mode-card__title">Mode Manual</h4>
                <p class="mode-card__desc">Pompa dijalankan secara langsung melalui tombol penyiraman di halaman dashboard.</p>

                <div class="mode-card__footer">
                    @if ($mode_manual == 1)
                        <button class="btn btn-soft-danger" onclick="confirmMode('off')">
                            <i class="bi bi-stop-circle"></i> Matikan
                        </button>
                    @else
                        <button class="btn btn-sky" onclick="confirmMode('manual')">
                            <i class="bi bi-hand-index-thumb"></i> Aktifkan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Threshold setting --}}
    <div class="threshold-panel">
        <div class="threshold-panel__head">
            <h5>Batas Kelembapan</h5>
            <p>Sistem akan merekomendasikan penyiraman jika kelembapan tanah berada di bawah nilai ini.</p>
        </div>

        <form id="thresholdForm" action="{{ route('kontrol.threshold') }}" method="POST">
            @csrf
            <div class="threshold-panel__body">
                <div class="threshold-input-wrap">
                    <label for="batas_kelembapan" class="threshold-label">
                        Siram jika kelembapan tanah ≤
                    </label>
                    <div class="threshold-input-row">
                        <input
                            type="number"
                            id="batas_kelembapan"
                            name="batas_kelembapan"
                            class="form-control"
                            min="0" max="100"
                            value="{{ $batas_kelembapan }}"
                        >
                        <span class="threshold-unit">%</span>
                        <button type="button" class="btn btn-garden" onclick="confirmSaveKelembapan()">
                            <i class="bi bi-check2"></i>
                            Simpan
                        </button>
                    </div>
                </div>

                <div class="threshold-note">
                    <i class="bi bi-info-circle"></i>
                    <span>Nilai saat ini: <strong>{{ $batas_kelembapan }}%</strong>. Sistem merekomendasikan <strong>Siram</strong> jika kelembapan tanah ≤ nilai tersebut.</span>
                </div>
            </div>
        </form>
    </div>

@endsection
