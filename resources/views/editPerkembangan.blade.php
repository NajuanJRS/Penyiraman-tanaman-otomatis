@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div>
            <span class="page-kicker">
                <i class="bi bi-image"></i>
                Histori
            </span>
            <h3>Edit Gambar Histori</h3>
            <p>Tambah, ganti, atau hapus gambar perkembangan tanaman.</p>
        </div>
        <div class="page-header-icon">
            <i class="bi bi-pencil-square"></i>
        </div>
    </div>

    <div class="form-panel">
        <form id="editForm" action="{{ route('histori.update', $perkembangan->id_perkembangan) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="section-title">
                <div>
                    <h5>Upload Gambar</h5>
                    <p>Pilih gambar tanaman terbaru untuk melengkapi data histori.</p>
                </div>
                <i class="bi bi-upload"></i>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label fw-bold">File Gambar</label>
                <input type="file" onchange="previewImage(event)" id="gambar" name="gambar" accept="image/*"
                    class="form-control modern-file">
                <small class="form-text text-muted">Format: JPG atau PNG, maksimal 2MB.</small>
            </div>

            <div class="image-preview-grid">
                <div>
                    <label class="form-label fw-bold">Preview Baru</label>
                    <div class="preview-box">
                        <img id="preview" class="img-preview" style="display: none;" alt="Preview gambar baru">
                        <span class="preview-empty">
                            <i class="bi bi-image"></i>
                            Belum ada gambar baru
                        </span>
                    </div>
                </div>

                @if ($perkembangan->gambar)
                    <div>
                        <label class="form-label fw-bold">Gambar Saat Ini</label>
                        <div class="preview-box">
                            <img src="{{ asset('storage/' . $perkembangan->gambar) }}" alt="Gambar Perkembangan"
                                class="img-preview">
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-garden" onclick="confirmSave()">
                    <i class="bi bi-save"></i>
                    Simpan Gambar
                </button>

                @if ($perkembangan->gambar)
                    <button type="button" class="btn btn-soft-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash"></i>
                        Hapus Gambar
                    </button>
                @endif

                <a href="{{ route('histori') }}" class="btn btn-soft-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>

    @if ($perkembangan->gambar)
        <form id="hapusForm" action="{{ route('histori.hapusGambar', $perkembangan->id_perkembangan) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
