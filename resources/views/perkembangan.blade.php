@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     Page Header
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-foreground tracking-tight">Histori Data Sensor</h1>
            <p class="text-sm text-muted-foreground mt-0.5">
                Riwayat pembacaan sensor, gambar tanaman, dan keputusan penyiraman.
            </p>
        </div>

        {{-- Toolbar Actions --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('histori.export') }}"
               class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors"
               style="background:oklch(0.45 0.13 145); color:#fff; text-decoration:none;"
               onmouseover="this.style.background='oklch(0.38 0.12 145)'"
               onmouseout="this.style.background='oklch(0.45 0.13 145)'">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>
</div>

{{-- Search Filter --}}
<div class="mb-4">
    <div class="relative max-w-sm">
        {{-- Search Icon Left --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        {{-- Plain input styled like BlatUI --}}
        <input
            type="text"
            id="searchInput"
            placeholder="Cari tanggal atau jam (16-06-2026 14:30)"
            class="flex h-9 w-full rounded-md border border-input bg-background pl-9 pr-9 text-sm shadow-xs outline-none transition-[color,box-shadow] placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50"
        >
        {{-- Calendar Button Right --}}
        <button type="button" id="btnDatetime"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-muted-foreground hover:text-foreground transition-colors focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </button>
        <input type="datetime-local" id="datetimePicker" class="hidden">
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     Data Table
═══════════════════════════════════════════════════════════════ --}}
<x-ui.table variant="card">
    <x-ui.table-header>
        <x-ui.table-row>
            <x-ui.table-head class="w-12 text-center">No</x-ui.table-head>
            <x-ui.table-head>Waktu</x-ui.table-head>
            <x-ui.table-head>Tanah</x-ui.table-head>
            <x-ui.table-head>Udara</x-ui.table-head>
            <x-ui.table-head>Suhu</x-ui.table-head>
            <x-ui.table-head class="text-center">Gambar</x-ui.table-head>
            <x-ui.table-head>Keputusan</x-ui.table-head>
            <x-ui.table-head class="text-right">Aksi</x-ui.table-head>
        </x-ui.table-row>
    </x-ui.table-header>
    <x-ui.table-body id="tableBody">
        @include('partials.tableHistori')
    </x-ui.table-body>
</x-ui.table>

{{-- Pagination Wrapper --}}
<div id="pagination" class="mt-4 overflow-x-auto">
    <div class="flex justify-center sm:justify-end">
        {{ $perkembangan->links() }}
    </div>
</div>

{{-- Image Preview Modal — Div based, reliable cross-browser --}}
<div id="imageModal"
     style="display:none; position:fixed; inset:0; z-index:9998; align-items:center; justify-content:center; padding:16px;">
    {{-- Backdrop --}}
    <div style="position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);"
         onclick="closeImageModal()"></div>
    {{-- Modal card --}}
    <div style="position:relative; z-index:9999; width:100%; max-width:640px; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid #e5e5e5;">
            <span style="font-size:14px; font-weight:600; color:#111;">Preview Gambar</span>
            <button type="button" onclick="closeImageModal()"
                    style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border:none; background:transparent; border-radius:6px; cursor:pointer; color:#666;"
                    onmouseover="this.style.background='#f0f0ee'" onmouseout="this.style.background='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        {{-- Body --}}
        <div style="display:flex; align-items:center; justify-content:center; padding:16px; background:#f9f9f7; min-height:200px;">
            <img id="modalImage" alt="Gambar Tanaman" src=""
                 style="max-width:100%; max-height:70vh; height:auto; object-fit:contain; border-radius:8px; box-shadow:0 2px 12px rgba(0,0,0,0.1);">
        </div>
    </div>
</div>

<script>
    // --- Search & Filter Logic ---
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const btnDatetime    = document.getElementById("btnDatetime");
        const datetimePicker = document.getElementById("datetimePicker");
        let debounceTimer;

        function performSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                let search = searchInput.value.trim();

                if (/^\d{2}-\d{2}-\d{4}/.test(search)) {
                    const parts  = search.split(' ');
                    const tanggal = parts[0].split('-');
                    search = `${tanggal[2]}-${tanggal[1]}-${tanggal[0]}`;
                    if (parts[1]) search += ` ${parts[1]}`;
                } else if (/^\d{2}-\d{2}$/.test(search)) {
                    const tanggal = search.split('-');
                    search = `-${tanggal[1]}-${tanggal[0]}`;
                }

                fetch(`/histori?search=${encodeURIComponent(search)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    document.getElementById("tableBody").innerHTML  = data.table;
                    document.getElementById("pagination").innerHTML = data.pagination;
                });
            }, 300);
        }

        if (searchInput) searchInput.addEventListener("input", performSearch);

        if (btnDatetime) {
            btnDatetime.addEventListener("click", () => datetimePicker.showPicker());
        }

        if (datetimePicker) {
            datetimePicker.addEventListener("change", function () {
                if (!this.value) return;
                const d  = new Date(this.value);
                const dd = String(d.getDate()).padStart(2, '0');
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const yy = d.getFullYear();
                const hh = String(d.getHours()).padStart(2, '0');
                const ii = String(d.getMinutes()).padStart(2, '0');
                searchInput.value = `${dd}-${mm}-${yy} ${hh}:${ii}`;
                searchInput.dispatchEvent(new Event("input"));
            });
        }
    });
</script>
@endsection
