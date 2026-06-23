@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     Page Header
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-foreground tracking-tight">Edit Gambar Histori</h1>
            <p class="text-sm text-muted-foreground mt-0.5">
                Tambah, ganti, atau hapus gambar perkembangan tanaman pada tanggal <strong>{{ \Carbon\Carbon::parse($perkembangan->waktu)->format('d/m/Y H:i') }}</strong>.
            </p>
        </div>
        <a href="{{ route('histori') }}"
           class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors"
           style="background:#6b7280; color:#fff; text-decoration:none;"
           onmouseover="this.style.background='#4b5563'"
           onmouseout="this.style.background='#6b7280'">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     Edit Form Card
═══════════════════════════════════════════════════════════════ --}}
<x-ui.card variant="sectioned">
    <x-ui.card-content class="pt-6">
        <form id="editForm"
              action="{{ route('histori.update', $perkembangan->id_perkembangan) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">
            @csrf
            @method('PUT')

            {{-- File Upload Section --}}
            <div>
                <label for="gambar" class="block text-sm font-semibold text-foreground mb-2">
                    Upload Gambar Baru
                </label>
                <div class="max-w-md">
                    <x-ui.input
                        type="file"
                        id="gambar"
                        name="gambar"
                        accept="image/*"
                        onchange="previewImage(event)"
                        class="cursor-pointer file:cursor-pointer file:bg-primary/10 file:text-primary file:font-semibold file:px-4 file:py-1 file:rounded-md file:mr-4 file:border-0 hover:file:bg-primary/20"
                    />
                    <p class="mt-2 text-xs text-muted-foreground">
                        Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran file: 2MB.
                    </p>
                </div>
            </div>

            <x-ui.separator />

            {{-- Previews Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Preview Baru --}}
                <div>
                    <p class="text-sm font-semibold text-foreground mb-3">Preview Gambar Baru</p>
                    <div class="aspect-video w-full rounded-lg border-2 border-dashed border-muted flex items-center justify-center bg-muted/10 overflow-hidden relative">
                        <img id="preview" class="w-full h-full object-cover" style="display:none;" alt="Preview baru">
                        <div class="flex flex-col items-center justify-center text-muted-foreground/60 p-4" id="previewEmpty">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>
                            <span class="text-sm font-medium">Belum ada gambar dipilih</span>
                        </div>
                    </div>
                </div>

                {{-- Gambar Saat Ini --}}
                @if ($perkembangan->gambar)
                    <div>
                        <p class="text-sm font-semibold text-foreground mb-3">Gambar Saat Ini</p>
                        <div class="aspect-video w-full rounded-lg border overflow-hidden bg-muted/10 relative group">
                            <img src="/storage/{{ $perkembangan->gambar }}"
                                 alt="Gambar Perkembangan"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <x-ui.separator />

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-3 mt-6">
                <x-ui.button type="button" onclick="confirmSave()" class="gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Gambar Baru
                </x-ui.button>

                @if ($perkembangan->gambar)
                    <x-ui.button type="button" variant="outline" class="text-destructive border-destructive/30 hover:bg-destructive/5 gap-2" onclick="confirmDelete()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                        Hapus Gambar Saat Ini
                    </x-ui.button>
                @endif
            </div>
        </form>
    </x-ui.card-content>
</x-ui.card>

{{-- Hidden Form Delete --}}
@if ($perkembangan->gambar)
    <form id="hapusForm"
          action="{{ route('histori.hapusGambar', $perkembangan->id_perkembangan) }}"
          method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endif

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const empty = document.getElementById('previewEmpty');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (empty) empty.style.display = 'none';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            if (empty) empty.style.display = 'flex';
        }
    }

    // Adaptasi confirm dari js global jika diperlukan
    function confirmSave() {
        if(typeof sgConfirm === 'function') {
            sgConfirm({
                title: 'Simpan Gambar?',
                text: 'Gambar histori akan diupdate dengan file baru yang Anda pilih.',
                tone: 'question',
                confirmText: 'Ya, simpan',
                cancelText: 'Batal'
            }).then((result) => {
                if (result) document.getElementById('editForm').submit();
            });
        } else {
            if(confirm('Simpan gambar baru?')) document.getElementById('editForm').submit();
        }
    }

    function confirmDelete() {
        if(typeof sgConfirm === 'function') {
            sgConfirm({
                title: 'Hapus Gambar?',
                text: 'Tindakan ini tidak bisa dibatalkan. Gambar akan dihapus secara permanen.',
                tone: 'danger',
                confirmText: 'Ya, hapus',
                cancelText: 'Batal'
            }).then((result) => {
                if (result) document.getElementById('hapusForm').submit();
            });
        } else {
            if(confirm('Hapus gambar permanen?')) document.getElementById('hapusForm').submit();
        }
    }
</script>
@endsection
