<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logika untuk Modal Konfirmasi Hapus
    var confirmDeleteModal = document.getElementById('confirmDeleteModal');
    if (confirmDeleteModal) {
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var url = button.getAttribute('data-url'); // Ambil URL dari atribut data-url
            var confirmButton = document.getElementById('confirmDeleteButton');
            confirmButton.setAttribute('href', url); // Atur href tombol "Ya, Hapus"
        });
    }

    // Logika untuk memunculkan Modal Error "Hit a snag" dari session
    <?php if (session()->getFlashdata('show_error_modal')): ?>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    <?php endif; ?>

    // Logika untuk login modal (jika ada di halaman user)
    const loginOrProfileIcon = document.getElementById('loginOrProfileIcon');
    if (loginOrProfileIcon) {
        const loginModal = new bootstrap.Modal(document.getElementById('loginFormModal'));
        loginOrProfileIcon.addEventListener('click', function() {
            loginModal.show();
        });
    }
});

// Logika untuk memperbaiki bug modal saat menekan tombol "Back" di browser
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Sembunyikan semua modal yang mungkin aktif
        document.querySelectorAll('.modal').forEach(modalEl => {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
        // Hapus backdrop yang mungkin tersisa
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
        document.body.classList.remove('modal-open');
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '';
    }
});
</script>