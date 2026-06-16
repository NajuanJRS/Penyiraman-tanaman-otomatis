@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <span class="page-kicker">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </span>
            <h3>Monitoring Smart Garden</h3>
            <p>Ringkasan kondisi sensor dan status sistem secara real-time.</p>
        </div>
        <div class="page-header-icon">
            <i class="bi bi-flower1"></i>
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

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="metric-card metric-soil">
                <div class="metric-icon">
                    <i class="bi bi-moisture"></i>
                </div>
                <div>
                    <span>Kelembapan Tanah</span>
                    <strong>{{ $tanah }}%</strong>
                    <small>Kondisi media tanam</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="metric-card metric-temp">
                <div class="metric-icon">
                    <i class="bi bi-thermometer-half"></i>
                </div>
                <div>
                    <span>Suhu</span>
                    <strong>{{ $suhu }}°C</strong>
                    <small>Suhu sekitar tanaman</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="metric-card metric-air">
                <div class="metric-icon">
                    <i class="bi bi-cloud-drizzle"></i>
                </div>
                <div>
                    <span>Kelembapan Udara</span>
                    <strong>{{ $udara }}%</strong>
                    <small>Kondisi udara kebun</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="metric-card metric-pump">
                <div class="metric-icon">
                    <i class="bi bi-power"></i>
                </div>
                <div>
                    <span>Status Pompa</span>
                    <strong class="metric-status">{{ $status }}</strong>
                    <small>Mode perangkat saat ini</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="chart-card">
                <div class="section-title">
                    <div>
                        <h5>Grafik Kelembapan</h5>
                        <p>Perbandingan kelembapan tanah dan udara periode {{ $periode }}.</p>
                    </div>
                    <i class="bi bi-activity"></i>
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
                        <p>Perubahan suhu lingkungan kebun periode {{ $periode }}.</p>
                    </div>
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="chart-wrap">
                    <canvas id="chartSuhu"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="decision-panel {{ $decision === 'Siram' ? 'needs-water' : 'is-safe' }}">
        <div class="decision-icon">
            <i class="bi {{ $decision === 'Siram' ? 'bi-droplet-fill' : 'bi-check2-circle' }}"></i>
        </div>
        <div class="decision-copy">
            <span>Rekomendasi Sistem</span>
            <h5>
                {{ $decision === 'Siram' ? 'Tanaman perlu disiram' : 'Tanaman tidak perlu disiram' }}
            </h5>
            <p>Tanah: {{ $tanah }}% • Suhu: {{ $suhu }}°C • Udara: {{ $udara }}%</p>
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
        var chartSuhu = {!! json_encode($chartSuhu) !!};

        new Chart(document.getElementById('chartKelembapan'), {
            type: 'line',
            data: {
                datasets: [{
                        label: 'Kelembapan Tanah (%)',
                        data: chartTanah,
                        borderWidth: 3,
                        borderColor: '#2f6b4f',
                        backgroundColor: '#2f6b4f',
                        tension: 0.45,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHitRadius: 20,
                    },
                    {
                        label: 'Kelembapan Udara (%)',
                        data: chartUdara,
                        borderWidth: 3,
                        borderColor: '#2f8fb8',
                        backgroundColor: '#2f8fb8',
                        tension: 0.35,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHitRadius: 20,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                events: ['mousemove', 'mouseout', 'click', 'touchstart', 'touchmove'],
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const date = new Date(context[0].parsed.x);
                                const tanggal = date.toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });
                                const jam = date.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                }).replace(/\./g, ':');

                                return `${tanggal}, ${jam}`;
                            }
                        }
                    },
                    title: {
                        display: false
                    },
                    legend: {
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 8,
                        hitRadius: 20
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'dd'
                            },
                        },
                        grid: {
                            color: 'rgba(32, 53, 44, 0.06)'
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
                        grid: {
                            color: 'rgba(32, 53, 44, 0.06)'
                        },
                        title: {
                            display: true,
                            text: 'Persentase (%)'
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartSuhu'), {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Suhu (°C)',
                    data: chartSuhu,
                    borderWidth: 3,
                    borderColor: '#e9853f',
                    backgroundColor: '#e9853f',
                    tension: 0.45,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHitRadius: 20,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                events: ['mousemove', 'mouseout', 'click', 'touchstart', 'touchmove'],
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const date = new Date(context[0].parsed.x);
                                const tanggal = date.toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });
                                const jam = date.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                }).replace(/\./g, ':');

                                return `${tanggal}, ${jam}`;
                            }
                        }
                    },
                    title: {
                        display: false
                    },
                    legend: {
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 8,
                        hitRadius: 20
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'dd'
                            },
                        },
                        grid: {
                            color: 'rgba(32, 53, 44, 0.06)'
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
                        grid: {
                            color: 'rgba(32, 53, 44, 0.06)'
                        },
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
