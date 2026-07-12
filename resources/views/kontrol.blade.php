@extends('layouts.app')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-foreground tracking-tight">Kontrol Penyiraman</h1>
            <p class="text-sm text-muted-foreground mt-0.5">
                Pilih mode pompa dan atur batas kelembapan untuk keputusan penyiraman.
            </p>
        </div>
        @php
            $pumpOn = ($mode_otomatis == 1 || $mode_manual == 1);
        @endphp
        <div class="flex items-center gap-2 flex-wrap">
            <x-ui.badge :tone="$sistemAktif ? 'success' : 'neutral'" variant="soft" size="lg" class="gap-1.5">
                <span class="relative flex size-2">
                    @if($sistemAktif)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                    @endif
                    <span class="relative inline-flex rounded-full size-2 {{ $sistemAktif ? 'bg-success' : 'bg-muted-foreground' }}"></span>
                </span>
                {{ $sistemAktif ? 'Sistem Aktif' : 'Sistem Nonaktif' }}
            </x-ui.badge>
            <x-ui.badge :tone="$pumpOn ? 'success' : 'neutral'" variant="soft" size="lg" class="gap-1.5">
                <span class="relative flex size-2">
                    @if($pumpOn)
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                    @endif
                    <span class="relative inline-flex rounded-full size-2 {{ $pumpOn ? 'bg-success' : 'bg-muted-foreground' }}"></span>
                </span>
                {{ $pumpOn ? 'Pompa Aktif' : 'Pompa Mati' }}
            </x-ui.badge>
        </div>
    </div>
</div>

{{-- Hidden forms --}}
<form id="formOtomatis" method="POST" action="{{ route('kontrol.otomatis') }}">@csrf</form>
<form id="formManual"   method="POST" action="{{ route('kontrol.manual') }}">@csrf</form>
<form id="formOff"      method="POST" action="{{ route('kontrol.off') }}">@csrf</form>

{{-- Mode Cards 2 kolom --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

    {{-- Mode Otomatis --}}
    <x-ui.card variant="sectioned" class="{{ $mode_otomatis == 1 ? 'ring-2 ring-primary/40' : '' }}">
        <x-ui.card-header>
            <div class="flex items-center justify-between">
                {{-- Icon --}}
                <div class="size-11 rounded-xl flex items-center justify-center
                    {{ $mode_otomatis == 1 ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/>
                        <line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>
                    </svg>
                </div>
                {{-- Badge status --}}
                <x-ui.badge :tone="$mode_otomatis == 1 ? 'success' : 'neutral'" variant="soft" size="sm">
                    {{ $mode_otomatis == 1 ? 'Aktif' : 'Nonaktif' }}
                </x-ui.badge>
            </div>
        </x-ui.card-header>

        <x-ui.card-content class="pt-1">
            <x-ui.card-title class="mb-1">Mode Otomatis</x-ui.card-title>
            <x-ui.card-description>
                Pompa menyiram secara otomatis berdasarkan pembacaan sensor kelembapan.
            </x-ui.card-description>
        </x-ui.card-content>

        <x-ui.card-footer class="pt-4 border-t">
            @if ($mode_otomatis == 1)
                <x-ui.button variant="outline" class="w-full text-destructive border-destructive/30 hover:bg-destructive/5 gap-2"
                    onclick="confirmMode('off')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><rect x="9" y="9" width="6" height="6" rx="1"/>
                    </svg>
                    Matikan Mode Otomatis
                </x-ui.button>
            @else
                <x-ui.button class="w-full gap-2" onclick="confirmMode('otomatis')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    Aktifkan Mode Otomatis
                </x-ui.button>
            @endif
        </x-ui.card-footer>
    </x-ui.card>

    {{-- Mode Manual --}}
    <x-ui.card variant="sectioned" class="{{ $mode_manual == 1 ? 'ring-2 ring-info/40' : '' }}">
        <x-ui.card-header>
            <div class="flex items-center justify-between">
                {{-- Icon --}}
                <div class="size-11 rounded-xl flex items-center justify-center
                    {{ $mode_manual == 1 ? 'bg-info text-info-foreground' : 'bg-muted text-muted-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/>
                        <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 11a2 2 0 1 1 4 0v3a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/>
                    </svg>
                </div>
                {{-- Badge status --}}
                <x-ui.badge :tone="$mode_manual == 1 ? 'info' : 'neutral'" variant="soft" size="sm">
                    {{ $mode_manual == 1 ? 'Aktif' : 'Nonaktif' }}
                </x-ui.badge>
            </div>
        </x-ui.card-header>

        <x-ui.card-content class="pt-1">
            <x-ui.card-title class="mb-1">Mode Manual</x-ui.card-title>
            <x-ui.card-description>
                Pompa dijalankan secara langsung tanpa intervensi sistem otomatis.
            </x-ui.card-description>
        </x-ui.card-content>

        <x-ui.card-footer class="pt-4 border-t">
            @if ($mode_manual == 1)
                <x-ui.button variant="outline" class="w-full text-destructive border-destructive/30 hover:bg-destructive/5 gap-2"
                    onclick="confirmMode('off')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><rect x="9" y="9" width="6" height="6" rx="1"/>
                    </svg>
                    Matikan Mode Manual
                </x-ui.button>
            @else
                <x-ui.button color="#2577a0" class="w-full gap-2" onclick="confirmMode('manual')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    Aktifkan Mode Manual
                </x-ui.button>
            @endif
        </x-ui.card-footer>
    </x-ui.card>

</div>
@endsection
