function confirmMode(mode) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Mode penyiraman akan diubah",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            if(mode == 'otomatis'){
                document.getElementById('formOtomatis').submit();
            }
            else if(mode == 'manual'){
                document.getElementById('formManual').submit();
            }
            else if(mode == 'off'){
                document.getElementById('formOff').submit();
            }
        }
    });
}

document.getElementById('siramForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyiram tanaman?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Siram!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

document.getElementById('search').addEventListener('keyup', function() {
    let search = this.value;

    fetch(`/histori?search=${search}`)
        .then(response => response.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newTable = doc.querySelector('#tableBody').innerHTML;
            document.querySelector('#tableBody').innerHTML = newTable;
        });
});
