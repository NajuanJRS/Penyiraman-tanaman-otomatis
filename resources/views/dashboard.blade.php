@extends('layouts.app')

@section('content')

    {{-- Page heading --}}
    <div class="page-header">
        <h3>Dashboard</h3>
        <p>Kondisi sensor dan status sistem secara real-time.</p>
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

    {{-- Metric cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="metric-card metric-soil">
                <div class="metric-icon">
                    <i class="bi bi-moisture"></i>
                </div>
                <div>
                    <span>Kelembapan Tanah</span>
                    <strong>{{ $tanah }}%</strong>
                    <small>Media tanam</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card metric-temp">
                <div class="metric-icon">
                    <i class="bi bi-thermometer-half"></i>
                </div>
                <div>
                    <span>Suhu</span>
                    <strong>{{ $suhu }}°C</strong>
                    <small>Sekitar tanaman</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card metric-air">
                <div class="metric-icon">
                    <i class="bi bi-cloud-drizzle"></i>
                </div>
                <div>
                    <span>Kelembapan Udara</span>
                    <strong>{{ $udara }}%</strong>
                    <small>Udara kebun</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="metric-card metric-pump">
                <div class="metric-icon">
                    <i class="bi bi-power"></i>
                </div>
                <div>
                    <span>Status Pompa</span>
                    <strong class="metric-status">{{ $status }}</strong>
                    <small>Mode pompa</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="chart-card">
                <div class="section-title">
                    <div>
                        <h5>Grafik Kelembapan</h5>
                        <p>Tanah dan udara — periode {{ $periode }}</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="chartKelembapan"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="chart-card">
                <div class="section-title">
                    <div>
                        <h5>Grafik Suhu</h5>
                        <p>Suhu lingkungan — periode {{ $periode }}</p>
                    </div>
                </div>
                <div class="chart-wrap">
                    <canvas id="chartSuhu"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recommendation panel --}}
    <div class="decision-panel {{ $decision === 'Siram' ? 'needs-water' : 'is-safe' }}">
        <div class="decision-icon">
            <i class="bi {{ $decision === 'Siram' ? 'bi-droplet-fill' : 'bi-check2-circle' }}"></i>
        </div>
        <div class="decision-copy">
            <span>Rekomendasi Sistem</span>
            <h5>{{ $decision === 'Siram' ? 'Tanaman perlu disiram' : 'Tanaman tidak perlu disiram' }}</h5>
            <p>Tanah: {{ $tanah }}% &bull; Suhu: {{ $suhu }}°C &bull; Udara: {{ $udara }}%</p>
        </div>

        @if ($decision === 'Siram')
            <form action="{{ route('kontrol.siram') }}" method="POST" id="siramForm" class="ms-md-auto">
                @csrf
                <button type="submit" class="btn btn-garden">
                    <i class="bi bi-droplet"></i>
                    Siram Sekarang
                </button>
            </form>
        @endif
    </div>

    <script>
        var chartTanah = {!! json_encode($chartTanah) !!};
        var chartUdara = {!! json_encode($chartUdara) !!};
        var chartSuhu  = {!! json_encode($chartSuhu) !!};

        const gridColor = 'rgba(0,0,0,0.05)';
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'nearest', axis: 'x', intersect: false },
            plugins: {
                legend: { labels: { usePointStyle: true, boxWidth: 7, font: { size: 12 } } },
                tooltip: {
                    callbacks: {
                        title: function(ctx) {
                            const d = new Date(ctx[0].parsed.x);
                            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
                                + ', '
                                + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(/\./g, ':');
                        }
                    }
                }
            },
            scales: {
                x: {
                    type: 'time',
                    time: { unit: 'day', displayFormats: { day: 'dd' } },
                    grid: { color: gridColor },
                    ticks: { autoSkip: true, maxTicksLimit: 10, font: { size: 11 } },
                    title: { display: true, text: 'Tanggal', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { font: { size: 11 } }
                }
            }
        };

        new Chart(document.getElementById('chartKelembapan'), {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Kelembapan Tanah (%)',
                        data: chartTanah,
                        borderWidth: 2,
                        borderColor: '#2d7a4a',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHitRadius: 20,
                    },
                    {
                        label: 'Kelembapan Udara (%)',
                        data: chartUdara,
                        borderWidth: 2,
                        borderColor: '#2577a0',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHitRadius: 20,
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: { ...commonOptions.scales.y, title: { display: true, text: '%', font: { size: 11 } } }
                }
            }
        });

        new Chart(document.getElementById('chartSuhu'), {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Suhu (°C)',
                    data: chartSuhu,
                    borderWidth: 2,
                    borderColor: '#b8601f',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHitRadius: 20,
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: { ...commonOptions.scales.y, title: { display: true, text: '°C', font: { size: 11 } } }
                }
            }
        });
    </script>
@endsection
