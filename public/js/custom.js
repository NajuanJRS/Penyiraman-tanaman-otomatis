function confirmMode(mode) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Mode penyiraman akan diubah",
        icon: 'warning',
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        showCancelButton: true,
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            if (mode == 'otomatis') {
                document.getElementById('formOtomatis').submit();
            }
            else if (mode == 'manual') {
                document.getElementById('formManual').submit();
            }
            else if (mode == 'off') {
                document.getElementById('formOff').submit();
            }
        }
    });
}

document.getElementById('siramForm').addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyiram tanaman?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Siram!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

function confirmSave() {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Perubahan gambar akan disimpan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').submit();
        }
    });
}

function confirmSaveKelembapan() {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Perubahan batas kelembapan akan disimpan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('thresholdForm').submit();
        }
    });
}

function previewImage(event) {
    let file = event.target.files[0];
    const preview = document.getElementById('preview');
    const empty = document.querySelector('.preview-empty');

    if (!file) {
        preview.style.display = 'none';
        preview.src = '';
        if (empty) empty.style.display = '';
        return;
    }

    let reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (empty) empty.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function confirmDelete() {

    Swal.fire({
        title: 'Hapus gambar?',
        text: "Gambar akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hapusForm').submit();
        }
    });
}

function showImage(src) {
    document.getElementById('modalImage').src = src;
}
