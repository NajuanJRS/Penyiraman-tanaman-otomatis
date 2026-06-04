@foreach ($perkembangan as $p)
    <tr>
        <td >{{ $perkembangan->firstItem() + $loop->index }}</td>
        <td>{{ \Carbon\Carbon::parse($p->waktu)->format('d/m/Y H:i:s') }}</td>
        <td>{{ $p->kelembapan_tanah }} %</td>
        <td>{{ $p->kelembapan_udara }} %</td>
        <td>{{ $p->suhu }} °C</td>
        <td>
            @if ($p->gambar)
                <img src="{{ Storage::url($p->gambar) }}" class="img-table preview-image" alt="Gambar Tanaman"
                    data-bs-toggle="modal" data-bs-target="#imageModal"
                    onclick="showImage('{{ Storage::url($p->gambar) }}')">
            @endif
        </td>
        <td>
            @if ($p->prediksi && $p->prediksi->decision == 'Siram')
                <span class="badge bg-success">Siram</span>
            @else
                <span class="badge bg-danger">Tidak Siram</span>
            @endif
        </td>
        <td>
            <a href="{{ route('histori.edit', $p->id_perkembangan) }}" class="btn btn-primary btn-edit-gambar">
                <i class="bi bi-pencil"></i>
            </a>
        </td>
    </tr>
@endforeach
