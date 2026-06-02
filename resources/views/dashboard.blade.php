@extends('layouts.app')

@section('content')
    <h3>Dashboard</h3>
    <p>Monitoring sensor dan status sistem real-time</p>

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
                <div style="height: 300px;">
                    <canvas id="chartKelembapan"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Suhu -->
        <div class="col-md-6">
            <div class="card-box">
                <h5>Grafik Suhu</h5>
                <div style="height: 300px;">
                    <canvas id="chartSuhu"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="card-box">
        <h5>Apakah tanaman perlu disiram?</h5>
        <p>Tanah: {{ $tanah }} | Suhu: {{ $suhu }} | Udara: {{ $udara }}</p>
        @if ($decision === 'Siram')
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
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
                datasets: [{
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
                        display: true,
                        text: 'Grafik Kelembapan - {{ $periode }}'
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
                        display: true,
                        text: 'Grafik Suhu - {{ $periode }}'
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
