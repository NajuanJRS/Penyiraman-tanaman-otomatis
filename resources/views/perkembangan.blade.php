@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h3>Histori Data Sensor</h3>
        <p>Riwayat pembacaan sensor, gambar tanaman, dan keputusan penyiraman.</p>
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

    {{-- Toolbar: search + export --}}
    <div class="histori-toolbar mb-3">
        <div class="histori-search">
            <span class="histori-search__icon"><i class="bi bi-search"></i></span>
            <input
                type="text"
                id="searchInput"
                class="histori-search__input"
                placeholder="Cari tanggal atau jam, contoh: 16-06-2026 14:30"
            >
            <button class="histori-search__btn" type="button" id="btnDatetime" aria-label="Pilih tanggal">
                <i class="bi bi-calendar3"></i>
            </button>
            <input type="datetime-local" id="datetimePicker" style="display:none;">
        </div>

        <a href="{{ route('histori.export') }}" class="btn btn-garden">
            <i class="bi bi-download"></i>
            Export CSV
        </a>
    </div>

    {{-- Table --}}
    <div class="data-panel">
        <div class="table-responsive">
            <table class="table data-table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Tanah</th>
                        <th>Udara</th>
                        <th>Suhu</th>
                        <th>Gambar</th>
                        <th>Keputusan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @include('partials.tableHistori')
                </tbody>
            </table>
        </div>

        <div id="pagination" class="pagination-wrap">
            {{ $perkembangan->links() }}
        </div>
    </div>

    {{-- Modal preview gambar --}}
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
            <div class="modal-content" style="border: 0; border-radius: 12px; overflow: hidden;">
                <div class="modal-header" style="border-bottom: 1px solid #f0f0ee; padding: 14px 18px;">
                    <span style="font-size: 14px; font-weight: 700; color: #111;">Preview Gambar</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" style="padding: 20px;">
                    <img id="modalImage" alt="Gambar Tanaman" src="" class="preview-modal-img">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
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
                        document.getElementById("tableBody").innerHTML    = data.table;
                        document.getElementById("pagination").innerHTML   = data.pagination;
                    });
                }, 300);
            }

            searchInput.addEventListener("input", performSearch);
        });

        const btnDatetime    = document.getElementById("btnDatetime");
        const datetimePicker = document.getElementById("datetimePicker");
        const searchInput    = document.getElementById("searchInput");

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
    </script>
@endsection
