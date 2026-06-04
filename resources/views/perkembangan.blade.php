@extends('layouts.app')

@section('content')
    <h3>Histori Data</h3>
    <p>Riwayat pembacaan sensor dan keputusan sistem</p>

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

    <div class="card-box mb-3">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" id="searchInput" class="form-control" placeholder="Cari tanggal atau jam...">

                    <button class="btn btn-outline-secondary" type="button" id="btnDatetime">

                        <i class="bi bi-calendar-event"></i>

                    </button>

                    <input type="datetime-local" id="datetimePicker" style="display:none;">

                </div>
            </div>

            <div class="col-md-4">
                <a href="{{ route('histori.export') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            </div>
        </div>
    </div>

    <div class="card-box table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Kelembapan Tanah</th>
                    <th>Kelembapan Udara</th>
                    <th>Suhu</th>
                    <th>Gambar</th>
                    <th>Keputusan</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @include('partials.tableHistori')
            </tbody>
        </table>
        <div id="pagination">
            {{ $perkembangan->links() }}
        </div>
    </div>
    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar</h5>
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
                    // dd-mm-yyyy
                    if (/^\d{2}-\d{2}-\d{4}/.test(search)) {

                        const parts = search.split(' ');
                        const tanggal = parts[0].split('-');

                        search =
                            `${tanggal[2]}-${tanggal[1]}-${tanggal[0]}`;

                        if (parts[1]) {
                            search += ` ${parts[1]}`;
                        }

                    }
                    // dd-mm
                    else if (/^\d{2}-\d{2}$/.test(search)) {

                        const tanggal = search.split('-');

                        search =
                            `-${tanggal[1]}-${tanggal[0]}`;

                    }

                    fetch(`/histori?search=${encodeURIComponent(search)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("tableBody").innerHTML =
                            data.table;

                        document.getElementById("pagination").innerHTML =
                            data.pagination;
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

                // Format Indonesia
                searchInput.value =
                    `${dd}-${mm}-${yyyy} ${hh}:${ii}`;

                searchInput.dispatchEvent(
                    new Event("input")
                );
            });
        }
    </script>
@endsection
