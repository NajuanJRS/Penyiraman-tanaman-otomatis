/* =========================================================
   Smart Garden — custom.js
   Toast + Confirm dialog bergaya BlatUI (tanpa SweetAlert)
   ========================================================= */

/* ── Toast ─────────────────────────────────────────────── */

/**
 * sgToast(message, tone)
 * tone: 'success' | 'error' | 'warning' | 'info'
 */
function sgToast(message, tone = 'success') {
    const container = document.getElementById('sg-toast-container');
    if (!container) return;

    const icons = {
        success: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>`,
        error:   `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
        warning: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
        info:    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
    };

    const toast = document.createElement('div');
    toast.className = `sg-toast sg-toast--${tone}`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <span class="sg-toast__icon">${icons[tone] || icons.info}</span>
        <span class="sg-toast__msg">${message}</span>
        <button class="sg-toast__close" aria-label="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="sg-toast__progress"></div>
    `;

    container.appendChild(toast);

    // Trigger animation
    requestAnimationFrame(() => toast.classList.add('sg-toast--show'));

    const dismiss = () => {
        toast.classList.remove('sg-toast--show');
        toast.classList.add('sg-toast--hide');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    };

    toast.querySelector('.sg-toast__close').addEventListener('click', dismiss);

    // Auto dismiss after 3.5s
    const timerId = setTimeout(dismiss, 3500);
    toast.querySelector('.sg-toast__close').addEventListener('click', () => clearTimeout(timerId));
}

/* ── Confirm Dialog ─────────────────────────────────────── */

/**
 * sgConfirm({ title, text, tone, confirmLabel, cancelLabel }) → Promise<boolean>
 * tone: 'warning' | 'danger' | 'question'
 */
function sgConfirm({ title = 'Apakah Anda yakin?', text = '', tone = 'warning', confirmLabel = 'Ya, lanjutkan', cancelLabel = 'Batal' } = {}) {
    return new Promise((resolve) => {
        const dialog   = document.getElementById('sg-confirm-dialog');
        const titleEl  = document.getElementById('sg-dialog-title');
        const textEl   = document.getElementById('sg-dialog-text');
        const btnOk    = document.getElementById('sg-dialog-confirm');
        const btnNo    = document.getElementById('sg-dialog-cancel');

        const iconWarning  = document.getElementById('sg-dialog-icon-warning');
        const iconDanger   = document.getElementById('sg-dialog-icon-danger');
        const iconQuestion = document.getElementById('sg-dialog-icon-question');
        const iconWrap     = document.getElementById('sg-dialog-icon-wrap');

        // Set text
        titleEl.textContent = title;
        textEl.textContent  = text;
        btnOk.textContent   = confirmLabel;
        btnNo.textContent   = cancelLabel;

        // Set tone
        iconWarning.style.display  = 'none';
        iconDanger.style.display   = 'none';
        iconQuestion.style.display = 'none';
        iconWrap.className         = `sg-dialog__icon-wrap sg-dialog__icon-wrap--${tone}`;
        btnOk.className            = `sg-btn sg-btn--${tone === 'danger' ? 'danger' : 'primary'}`;

        if (tone === 'danger')    iconDanger.style.display   = '';
        else if (tone === 'question') iconQuestion.style.display = '';
        else                      iconWarning.style.display  = '';

        dialog.showModal();

        const close = (result) => {
            dialog.close();
            resolve(result);
            btnOk.removeEventListener('click', onOk);
            btnNo.removeEventListener('click', onNo);
            dialog.removeEventListener('cancel', onCancel);
        };

        const onOk     = () => close(true);
        const onNo     = () => close(false);
        const onCancel = () => close(false);   // Esc key

        btnOk.addEventListener('click',  onOk,     { once: true });
        btnNo.addEventListener('click',  onNo,     { once: true });
        dialog.addEventListener('cancel', onCancel, { once: true });
    });
}

/* ── Auto flash from server session ────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const flashSuccess = body.dataset.flashSuccess;
    const flashError   = body.dataset.flashError;

    if (flashSuccess && flashSuccess.trim() !== '') {
        sgToast(flashSuccess, 'success');
    }
    if (flashError && flashError.trim() !== '') {
        sgToast(flashError, 'error');
    }
});

/* ── confirmMode (halaman Kontrol) ─────────────────────── */
function confirmMode(mode) {
    const labels = {
        otomatis: 'Mode Otomatis akan diaktifkan. Pompa akan bekerja secara otomatis berdasarkan sensor.',
        manual:   'Mode Manual akan diaktifkan. Pompa dijalankan langsung.',
        off:      'Mode pompa akan dimatikan.',
    };

    sgConfirm({
        title:        'Ubah Mode Penyiraman?',
        text:         labels[mode] || 'Mode penyiraman akan diubah.',
        tone:         'warning',
        confirmLabel: 'Ya, ubah',
    }).then((confirmed) => {
        if (!confirmed) return;
        const formId = { otomatis: 'formOtomatis', manual: 'formManual', off: 'formOff' }[mode];
        if (formId) document.getElementById(formId).submit();
    });
}

/* ── Konfirmasi siram (dashboard) ──────────────────────── */
const siramForm = document.getElementById('siramForm');
if (siramForm) {
    siramForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        sgConfirm({
            title:        'Siram Tanaman?',
            text:         'Pompa akan dijalankan untuk menyiram tanaman sekarang.',
            tone:         'question',
            confirmLabel: 'Ya, Siram!',
        }).then((confirmed) => {
            if (confirmed) form.submit();
        });
    });
}

/* ── confirmSaveKelembapan ──────────────────────────────── */
function confirmSaveKelembapan() {
    sgConfirm({
        title:        'Simpan Batas Kelembapan?',
        text:         'Nilai batas akan diperbarui dan mulai berlaku pada pembacaan sensor berikutnya.',
        tone:         'warning',
        confirmLabel: 'Ya, simpan',
    }).then((confirmed) => {
        if (confirmed) document.getElementById('thresholdForm').submit();
    });
}

/* ── confirmSave (edit gambar) ──────────────────────────── */
function confirmSave() {
    sgConfirm({
        title:        'Simpan Perubahan?',
        text:         'Gambar tanaman akan diperbarui.',
        tone:         'warning',
        confirmLabel: 'Ya, simpan',
    }).then((confirmed) => {
        if (confirmed) document.getElementById('editForm').submit();
    });
}

/* ── confirmDelete ──────────────────────────────────────── */
function confirmDelete() {
    sgConfirm({
        title:        'Hapus Gambar?',
        text:         'Gambar akan dihapus secara permanen dan tidak bisa dikembalikan.',
        tone:         'danger',
        confirmLabel: 'Ya, hapus',
    }).then((confirmed) => {
        if (confirmed) document.getElementById('hapusForm').submit();
    });
}

/* ── previewImage ───────────────────────────────────────── */
function previewImage(event) {
    const file    = event.target.files[0];
    const preview = document.getElementById('preview');
    const empty   = document.getElementById('previewEmpty')
                 || document.querySelector('.preview-empty')
                 || document.querySelector('.edit-preview-empty');

    if (!file) {
        preview.style.display = 'none';
        preview.src = '';
        if (empty) empty.style.display = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (empty) empty.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

/* ── showImage / closeImageModal (modal preview gambar) ────── */
function showImage(src) {
    const modal = document.getElementById('imageModal');
    if (!modal) return;
    document.getElementById('modalImage').src = src;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (!modal) return;
    modal.style.display = 'none';
    document.getElementById('modalImage').src = '';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeImageModal();
});
