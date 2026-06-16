@foreach ($perkembangan as $p)
    <tr>
        <td>
            <span class="row-number">{{ $perkembangan->firstItem() + $loop->index }}</span>
        </td>
        <td>
            <div class="time-cell">
                <strong>{{ \Carbon\Carbon::parse($p->waktu)->format('d/m/Y') }}</strong>
                <span>{{ \Carbon\Carbon::parse($p->waktu)->format('H:i:s') }}</span>
            </div>
        </td>
        <td>
            <span class="sensor-chip soil">
                <i class="bi bi-moisture"></i>
                {{ $p->kelembapan_tanah }}%
            </span>
        </td>
        <td>
            <span class="sensor-chip air">
                <i class="bi bi-cloud-drizzle"></i>
                {{ $p->kelembapan_udara }}%
            </span>
        </td>
        <td>
            <span class="sensor-chip temp">
                <i class="bi bi-thermometer-half"></i>
                {{ $p->suhu }}°C
            </span>
        </td>
        <td>
            @if ($p->gambar)
                <img src="{{ Storage::url($p->gambar) }}" class="img-table preview-image" alt="Gambar Tanaman"
                    data-bs-toggle="modal" data-bs-target="#imageModal"
                    onclick="showImage('{{ Storage::url($p->gambar) }}')">
            @else
                <span class="empty-image">
                    <i class="bi bi-image"></i>
                </span>
            @endif
        </td>
        <td>
            @if ($p->prediksi && $p->prediksi->decision == 'Siram')
                <span class="decision-badge water">
                    <i class="bi bi-droplet-fill"></i>
                    Siram
                </span>
            @else
                <span class="decision-badge safe">
                    <i class="bi bi-x-circle-fill"></i>
                    Tidak Siram
                </span>
            @endif
        </td>
        <td>
            <a href="{{ route('histori.edit', $p->id_perkembangan) }}" class="btn btn-table-action">
                <i class="bi bi-pencil"></i>
            </a>
        </td>
    </tr>
@endforeach
