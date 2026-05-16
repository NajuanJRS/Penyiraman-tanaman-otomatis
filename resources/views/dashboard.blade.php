@extends('layouts.app')

@section('content')

<h3>Dashboard</h3>
<p>Monitoring sensor dan status sistem real-time</p>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-box">
            <h6>Kelembapan Tanah</h6>
            <h3>{{ $tanah }} %</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Suhu</h6>
            <h3>{{ $suhu }} °C</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Kelembapan Udara</h6>
            <h3>{{ $udara }} %</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Status Pompa</h6>
            <h5>{{ $status }}</h5>
        </div>
    </div>
</div>

<div class="row mb-4">

    <!-- Grafik Kelembapan -->
    <div class="col-md-6">
        <div class="card-box">
            <h5>Grafik Kelembapan Tanah & Udara</h5>
            <canvas id="chartKelembapan"></canvas>
        </div>
    </div>

    <!-- Grafik Suhu -->
    <div class="col-md-6">
        <div class="card-box">
            <h5>Grafik Suhu</h5>
            <canvas id="chartSuhu"></canvas>
        </div>
    </div>

</div>

<div class="card-box">
    <h5>Apakah tanaman perlu disiram?</h5>
    <p>Tanah: {{ $tanah }} | Suhu: {{ $suhu }} | Udara: {{ $udara }}</p>
    @if($decision === 'Siram')

        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0">
                <b>Ya, tanaman perlu disiram</b>
            </h5>

            <form action="{{ route('kontrol.siram') }}" method="POST" id="siramForm">
                @csrf
                <button type="submit" class="btn btn-success">
                    💧 Siram Sekarang
                </button>
            </form>
        </div>

    @else
        <h5><b>Tanaman tidak perlu disiram</b></h5>
    @endif
</div>

<script>
var chartTanah = {!! json_encode($chartTanah) !!};
var chartUdara = {!! json_encode($chartUdara) !!};
var chartSuhu = {!! json_encode($chartSuhu) !!};

// Grafik Kelembapan
new Chart(document.getElementById('chartKelembapan'), {
    type: 'line',
    data: {
        datasets: [
            {
                label: 'Kelembapan Tanah (%)',
                data: chartTanah,
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: 'Kelembapan Udara (%)',
                data: chartUdara,
                borderWidth: 2,
                tension: 0.3
            }
        ]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Grafik Kelembapan - {{ $periode }}'
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd'
                    }
                },
                ticks: {
                    autoSkip: true,
                    maxTicksLimit: 10
                },
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Persentase (%)'
                }
            }
        }
    }
});

// Grafik Suhu
new Chart(document.getElementById('chartSuhu'), {
    type: 'line',
    data: {
        datasets: [{
            label: 'Suhu (°C)',
            data: chartSuhu,
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Grafik Suhu - {{ $periode }}'
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd'
                    }
                },
                ticks: {
                    autoSkip: true,
                    maxTicksLimit: 10
                },
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Suhu (°C)'
                }
            }
        }
    }
});
</script>
@endsection

