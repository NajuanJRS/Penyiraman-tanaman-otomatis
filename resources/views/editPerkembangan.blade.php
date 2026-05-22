@extends('layouts.app')

@section('content')
    <h3>Edit Gambar Histori</h3>
    <p>Form tambah atau ubah gambar untuk perkembangan tanaman</p>

    <div class="card-box">
        <form id="editForm" action="{{ route('histori.update', $perkembangan->id_perkembangan) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" onchange="previewImage(event)" id="gambar" name="gambar" accept="image/*"
                    class="form-control">
                <small class="form-text text-muted">Format: JPG, PNG (Max: 2MB)</small>
            </div>

            {{-- Preview gambar baru --}}
            <div class="mb-3">
                <img id="preview" class="img-preview" style="display: none;">
            </div>

            {{-- Gambar lama --}}
            @if ($perkembangan->gambar)
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div>
                        <img src="{{ asset('storage/' . $perkembangan->gambar) }}" alt="Gambar Perkembangan"
                            class="img-preview">
                    </div>
                </div>
            @endif

            <div class="d-flex flex-wrap flex-md-row gap-2 mt-3 align-items-start">

                {{-- HAPUS GAMBAR --}}
                @if ($perkembangan->gambar)
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">

                        <i class="bi bi-trash"></i>
                        Hapus Gambar

                    </button>
                @endif
            </div>

            <div class="d-flex flex-wrap flex-md-row gap-2 mt-3 align-items-start">

                <button type="button" class="btn btn-primary" onclick="confirmSave()">
                    <i class="bi bi-save"></i>
                    Simpan Gambar
                </button>

                    <a href="{{ route('histori') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
            </div>

    </div>
    </form>

    {{-- FORM HAPUS --}}
    @if ($perkembangan->gambar)
        <form id="hapusForm" action="{{ route('histori.hapusGambar', $perkembangan->id_perkembangan) }}" method="POST">

            @csrf
            @method('DELETE')

        </form>
    @endif
    </div>

@endsection
