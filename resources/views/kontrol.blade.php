@extends('layouts.app')

@section('content')

<h3>Kontrol Manual dan Otomatis</h3>
<p>Kendalikan Pompa Air secara manual dan otomatis</p>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>

@endif

<div class="row">

    <!-- Mode Otomatis -->
    <div class="col-md-6">
        <div class="card-box text-center">
            <h4>Mode Penyiraman Otomatis</h4>

            <p>Status:
                @if($mode_otomatis == 1)
                    <span class="text-success">Aktif</span>
                @else
                    <span class="text-danger">Nonaktif</span>
                @endif
            </p>

            <i class="bi bi-power" style="font-size: 80px;"></i>

            <form id="formOtomatis" method="POST" action="/kontrol/otomatis">
                @csrf
            </form>

            <form id="formOff" method="POST" action="/kontrol/off">
                @csrf
            </form>

            @if($mode_otomatis == 1)
                <button class="btn btn-danger mt-3" onclick="confirmMode('off')">
                    Matikan Mode
                </button>
            @else
                <button class="btn btn-primary mt-3" onclick="confirmMode('otomatis')">
                    Aktifkan Mode
                </button>
            @endif
        </div>
    </div>

    <!-- Mode Manual -->
    <div class="col-md-6">
        <div class="card-box text-center">
            <h4>Mode Penyiraman Manual</h4>

            <p>Status:
                @if($mode_manual == 1)
                    <span class="text-success">Aktif</span>
                @else
                    <span class="text-danger">Nonaktif</span>
                @endif
            </p>

            <i class="bi bi-power" style="font-size: 80px;"></i>

            <form id="formManual" method="POST" action="/kontrol/manual">
                @csrf
            </form>

            @if($mode_manual == 1)
                <button class="btn btn-danger mt-3" onclick="confirmMode('off')">
                    Matikan Mode
                </button>
            @else
                <button class="btn btn-primary mt-3" onclick="confirmMode('manual')">
                    Aktifkan Mode
                </button>
            @endif
        </div>
    </div>

</div>

@endsection
