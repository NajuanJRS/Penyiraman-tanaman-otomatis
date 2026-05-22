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


// Grafik Kelembapan
new Chart(document.getElementById('chartKelembapan'), {
    type: 'line',
    data: {
        datasets: [
            {
                label: 'Kelembapan Tanah (%)',
                data: chartTanah,
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: 'Kelembapan Udara (%)',
                data: chartUdara,
                borderWidth: 2,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Grafik Kelembapan - {{ $periode }}'
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd'
                    }
                },
                ticks: {
                    autoSkip: true,
                    maxTicksLimit: 10
                },
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Persentase (%)'
                }
            }
        }
    }
});

// Grafik Suhu
new Chart(document.getElementById('chartSuhu'), {
    type: 'line',
    data: {
        datasets: [{
            label: 'Suhu (°C)',
            data: chartSuhu,
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Grafik Suhu - {{ $periode }}'
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd'
                    }
                },
                ticks: {
                    autoSkip: true,
                    maxTicksLimit: 10
                },
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Suhu (°C)'
                }
            }
        }
    }
});

document.getElementById('siramForm').addEventListener('submit', function(e) {
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

function previewImage(event) {
    let file = event.target.files[0];
    if (!file) return;
    let reader = new FileReader();

    reader.onload = function(e) {
        let preview = document.getElementById('preview');
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
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

function showImage(src)
{
    document.getElementById('modalImage').src = src;
}
