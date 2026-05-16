@extends('layouts.app')

@section('content')

<h3>Histori Data</h3>
<p>Riwayat pembacaan sensor dan keputusan sistem</p>

<div class="card-box mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" id="search" class="form-control" placeholder="Filter tanggal...">
        </div>

        <div class="col-md-4">
            <a href="/histori/export" class="btn btn-success">
                <i class="bi bi-download"></i> Export CSV
            </a>
        </div>
    </div>
</div>

<div class="card-box">
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
            @foreach($perkembangan as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->waktu }}</td>
                <td>{{ $p->kelembapan_tanah }} %</td>
                <td>{{ $p->kelembapan_udara }} %</td>
                <td>{{ $p->suhu }} °C</td>
                <td>
                    @if($p->gambar)
                        <img src="{{ Storage::url($p->gambar) }}" alt="Gambar Perkembangan" class="img-table" alt="Gambar">
                    @endif
                </td>
                <td>
                    @if($p->prediksi && $p->prediksi->decision == 'Siram')
                        <span class="badge bg-success">Siram</span>
                    @else
                        <span class="badge bg-danger">Tidak Siram</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('histori.edit', $p->id_perkembangan) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $perkembangan->links() }}
</div>

@endsection
