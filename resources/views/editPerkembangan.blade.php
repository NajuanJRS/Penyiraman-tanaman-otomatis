@extends('layouts.app')

@section('content')

    <div class="page-header">
        <div>
            <h3>Edit Gambar Histori</h3>
            <p>Tambah, ganti, atau hapus gambar perkembangan tanaman.</p>
        </div>
        <a href="{{ route('histori') }}" class="btn btn-soft-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="edit-form-panel">
        <form id="editForm"
              action="{{ route('histori.update', $perkembangan->id_perkembangan) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Upload field --}}
            <div class="edit-form-section">
                <label for="gambar" class="edit-field-label">Upload Gambar Baru</label>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept="image/*"
                    class="edit-file-input"
                    onchange="previewImage(event)"
                >
                <p class="edit-field-hint">Format JPG atau PNG, maksimal 2MB.</p>
            </div>

            {{-- Preview grid --}}
            <div class="edit-preview-grid">
                <div>
                    <p class="edit-preview-label">Preview Baru</p>
                    <div class="edit-preview-box">
                        <img id="preview" class="edit-preview-img" style="display:none;" alt="Preview baru">
                        <div class="edit-preview-empty" id="previewEmpty">
                            <i class="bi bi-image"></i>
                            <span>Belum ada gambar</span>
                        </div>
                    </div>
                </div>

                @if ($perkembangan->gambar)
                    <div>
                        <p class="edit-preview-label">Gambar Saat Ini</p>
                        <div class="edit-preview-box">
                            <img src="{{ asset('storage/' . $perkembangan->gambar) }}"
                                 alt="Gambar Perkembangan"
                                 class="edit-preview-img">
                        </div>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="edit-form-actions">
                <button type="button" class="btn btn-garden" onclick="confirmSave()">
                    <i class="bi bi-check2"></i>
                    Simpan Gambar
                </button>

                @if ($perkembangan->gambar)
                    <button type="button" class="btn btn-soft-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash"></i>
                        Hapus Gambar
                    </button>
                @endif
            </div>
        </form>
    </div>

    @if ($perkembangan->gambar)
        <form id="hapusForm"
              action="{{ route('histori.hapusGambar', $perkembangan->id_perkembangan) }}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif

@endsection
