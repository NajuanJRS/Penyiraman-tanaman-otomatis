@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     Page Header
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-foreground tracking-tight">Dashboard</h1>
            <p class="text-sm text-muted-foreground mt-0.5">
                Kondisi sensor dan status sistem secara <span class="text-primary font-medium">real-time</span>.
            </p>
        </div>
        <x-ui.badge tone="success" variant="soft" size="lg" class="gap-1.5">
            <span class="relative flex size-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                <span class="relative inline-flex rounded-full size-2 bg-success"></span>
            </span>
            Sistem Aktif
        </x-ui.badge>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     Stat Cards — 4 kolom
═══════════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

    {{-- Kelembapan Tanah --}}
    <x-ui.stat
        label="Kelembapan Tanah"
        :value="$tanah . '%'"
        caption="Media tanam"
    >
        <x-slot:leading>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 9 2 13a10 10 0 0020 0C22 9 17.52 2 12 2z"/>
            </svg>
        </x-slot:leading>
    </x-ui.stat>

    {{-- Suhu --}}
    <x-ui.stat
        label="Suhu"
        :value="$suhu . '°C'"
        caption="Sekitar tanaman"
    >
        <x-slot:leading>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v10m0 0a4 4 0 100 8 4 4 0 000-8zm0 0V2"/>
            </svg>
        </x-slot:leading>
    </x-ui.stat>

    {{-- Kelembapan Udara --}}
    <x-ui.stat
        label="Kelembapan Udara"
        :value="$udara . '%'"
        caption="Udara kebun"
    >
        <x-slot:leading>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a9 9 0 0118 0M3 15H2m19 0h-1"/>
            </svg>
        </x-slot:leading>
    </x-ui.stat>

    {{-- Status Pompa --}}
    <x-ui.stat
        label="Status Pompa"
        :value="$status"
        :caption="$decision"
    >
        <x-slot:leading>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 {{ $status === 'Aktif' ? 'text-success' : 'text-muted-foreground' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
            </svg>
        </x-slot:leading>
    </x-ui.stat>

</div>



{{-- ═══════════════════════════════════════════════════════════════
     Grafik — 2 kolom
═══════════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-6">

    {{-- Grafik Kelembapan --}}
    <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
            <div class="flex items-center justify-between">
                <div>
                    <x-ui.card-title>Grafik Kelembapan</x-ui.card-title>
                    <x-ui.card-description>Tanah & udara — periode {{ $periode }}</x-ui.card-description>
                </div>
                <div class="flex gap-2">
                    <x-ui.badge tone="neutral" variant="soft" size="sm">Tanah</x-ui.badge>
                    <x-ui.badge tone="info" variant="soft" size="sm">Udara</x-ui.badge>
                </div>
            </div>
        </x-ui.card-header>
        <x-ui.card-content class="pt-2">
            <div class="chart-canvas-wrap">
                <canvas id="chartKelembapan"></canvas>
            </div>
        </x-ui.card-content>
    </x-ui.card>

    {{-- Grafik Suhu --}}
    <x-ui.card variant="sectioned">
        <x-ui.card-header class="border-b">
            <div class="flex items-center justify-between">
                <div>
                    <x-ui.card-title>Grafik Suhu</x-ui.card-title>
                    <x-ui.card-description>Suhu lingkungan — periode {{ $periode }}</x-ui.card-description>
                </div>
                <x-ui.badge tone="warning" variant="soft" size="sm">°C</x-ui.badge>
            </div>
        </x-ui.card-header>
        <x-ui.card-content class="pt-2">
            <div class="chart-canvas-wrap">
                <canvas id="chartSuhu"></canvas>
            </div>
        </x-ui.card-content>
    </x-ui.card>

</div>

{{-- ═══════════════════════════════════════════════════════════════
     Rekomendasi & Tombol Siram
═══════════════════════════════════════════════════════════════ --}}
@if ($decision === 'Siram')
    <x-ui.alert tone="warning" class="mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 9 2 13a10 10 0 0020 0C22 9 17.52 2 12 2z"/>
        </svg>
        <div class="flex-1 min-w-0">
            <x-ui.alert-title>Tanaman Perlu Disiram</x-ui.alert-title>
            <x-ui.alert-description>
                <p class="mb-2">Kondisi sensor saat ini menunjukkan tanaman membutuhkan penyiraman.</p>
                <p class="mb-3"><b>Tanah &nbsp;: {{ $tanah }}%<br>
                Udara &nbsp;: {{ $udara }}%<br>
                Suhu &nbsp;&nbsp;: {{ $suhu }}°C</b></p>
                <form action="{{ route('kontrol.siram') }}" method="POST" id="siramForm">
                    @csrf
                    <x-ui.button type="submit" color="#d97706" size="sm" class="w-full sm:w-auto gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 9 2 13a10 10 0 0020 0C22 9 17.52 2 12 2z"/>
                        </svg>
                        Siram Sekarang
                    </x-ui.button>
                </form>
            </x-ui.alert-description>
        </div>
    </x-ui.alert>
@else
    <x-ui.alert tone="success" class="mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <div class="flex-1 min-w-0">
            <x-ui.alert-title>Tanaman Dalam Kondisi Baik</x-ui.alert-title>
            <x-ui.alert-description>
                <p class="mb-2">Semua nilai sensor dalam batas normal. Tidak perlu penyiraman saat ini.</p>
                <p><b>Tanah &nbsp;: {{ $tanah }}% <br>
                Udara &nbsp;: {{ $udara }}% <br>
                Suhu &nbsp;&nbsp;: {{ $suhu }}°C</b></p>
            </x-ui.alert-description>
        </div>
    </x-ui.alert>
@endif


{{-- ═══════════════════════════════════════════════════════════════
     Chart.js Script
═══════════════════════════════════════════════════════════════ --}}
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
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.05)',
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHitRadius: 20,
                    fill: true,
                },
                {
                    label: 'Kelembapan Udara (%)',
                    data: chartUdara,
                    borderWidth: 2,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14,165,233,0.05)',
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHitRadius: 20,
                    fill: true,
                }
            ]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: { ...commonOptions.scales.y, max: 100, title: { display: true, text: '%', font: { size: 11 } } }
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
                borderColor: '#f97316',
                backgroundColor: 'rgba(249,115,22,0.05)',
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHitRadius: 20,
                fill: true,
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: { 
                    ...commonOptions.scales.y, 
                    suggestedMax: Math.max(...chartSuhu.map(item => item.y)) + 2, 
                    title: { display: true, text: '°C', font: { size: 11 } } 
                }
            }
        }
    });
</script>

@endsection
