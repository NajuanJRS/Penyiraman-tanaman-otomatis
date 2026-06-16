@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <span class="page-kicker">
                <i class="bi bi-clock-history"></i>
                Histori
            </span>
            <h3>Histori Data Sensor</h3>
            <p>Riwayat pembacaan sensor, gambar tanaman, dan keputusan penyiraman.</p>
        </div>
        <div class="page-header-icon">
            <i class="bi bi-table"></i>
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

    <div class="toolbar-panel mb-3">
        <div class="history-search">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>

            <input type="text" id="searchInput" class="form-control" placeholder="Cari tanggal atau jam (contoh: 16-06-2026 14:30)">

            <button class="btn btn-icon-soft" type="button" id="btnDatetime" aria-label="Pilih tanggal dan jam">
                <i class="bi bi-calendar-event"></i>
            </button>

            <input type="datetime-local" id="datetimePicker" style="display:none;">
        </div>

        <a href="{{ route('histori.export') }}" class="btn btn-garden">
            <i class="bi bi-download"></i>
            Export CSV
        </a>
    </div>

    <div class="data-panel">
        <div class="table-responsive">
            <table class="table data-table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Kelembapan Tanah</th>
                        <th>Kelembapan Udara</th>
                        <th>Suhu</th>
                        <th>Gambar</th>
                        <th>Keputusan</th>
                        <th>Aksi</th>
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

    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content image-modal">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-image"></i>
                        Preview Gambar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" alt="Gambar Tanaman" src="" class="preview-modal-img">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            let debounceTimer;

            function performSearch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    let search = searchInput.value.trim();

                    if (/^\d{2}-\d{2}-\d{4}/.test(search)) {
                        const parts = search.split(' ');
                        const tanggal = parts[0].split('-');
                        search = `${tanggal[2]}-${tanggal[1]}-${tanggal[0]}`;

                        if (parts[1]) {
                            search += ` ${parts[1]}`;
                        }
                    } else if (/^\d{2}-\d{2}$/.test(search)) {
                        const tanggal = search.split('-');
                        search = `-${tanggal[1]}-${tanggal[0]}`;
                    }

                    fetch(`/histori?search=${encodeURIComponent(search)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("tableBody").innerHTML = data.table;
                        document.getElementById("pagination").innerHTML = data.pagination;
                    });
                }, 300);
            }

            searchInput.addEventListener("input", performSearch);
        });

        const btnDatetime = document.getElementById("btnDatetime");
        const datetimePicker = document.getElementById("datetimePicker");
        const searchInput = document.getElementById("searchInput");

        if (btnDatetime) {
            btnDatetime.addEventListener("click", function() {
                datetimePicker.showPicker();
            });
        }

        if (datetimePicker) {
            datetimePicker.addEventListener("change", function() {
                const value = this.value;
                if (!value) return;

                const date = new Date(value);
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                const hh = String(date.getHours()).padStart(2, '0');
                const ii = String(date.getMinutes()).padStart(2, '0');

                searchInput.value = `${dd}-${mm}-${yyyy} ${hh}:${ii}`;
                searchInput.dispatchEvent(new Event("input"));
            });
        }
    </script>
@endsection
