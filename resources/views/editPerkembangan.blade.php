@extends('layouts.app')

@section('content')

<h3>Edit Gambar Histori</h3>
<p>Form tambah atau ubah gambar untuk perkembangan tanaman</p>

<div class="card-box">
    <form action="{{ route('histori.update', $perkembangan->id_perkembangan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" onchange="previewImage(event)" id="gambar" name="gambar" accept="image/*" class="form-control">
            <small class="form-text text-muted">Format: JPG, PNG (Max: 2MB)</small>
        </div>

        {{-- Preview gambar baru --}}
        <div class="mb-3">
            <img id="preview" class="img-preview" style="max-width: 300px; display: none;">
        </div>

        {{-- Gambar lama --}}
        @if($perkembangan->gambar)
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label>
            <div>
                <img src="{{ asset('storage/' . $perkembangan->gambar) }}" alt="Gambar Perkembangan" style="max-width: 300px;" class="img-preview">
            </div>
        </div>
        @endif

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Gambar
        </button>
    </form>
</div>

<script>
function previewImage(event){
    let file = event.target.files[0];

    if(!file) return;

    let reader = new FileReader();

    reader.onload = function(e){
        let preview = document.getElementById('preview');
        preview.src = e.target.result;
        preview.style.display = 'block';
    }

    reader.readAsDataURL(file);
}
</script>
@endsection


