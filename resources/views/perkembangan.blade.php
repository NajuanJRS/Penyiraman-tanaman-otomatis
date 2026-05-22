@extends('layouts.app')

@section('content')

<h3>Histori Data</h3>
<p>Riwayat pembacaan sensor dan keputusan sistem</p>

@if(session('success'))
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

                <img id="modalImage" alt="Gambar Tanaman" src="" class="img-fluid rounded" style="max-height: 80vh;">

            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    let debounceTimer;
    searchInput.addEventListener("keyup", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            let search = this.value;
            fetch(`/histori?search=${search}`, {
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
    });
});
</script>
@endsection
