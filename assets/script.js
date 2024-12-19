// Ambil elemen dropdown
const profileContainer = document.getElementById('profile-container');
const dropdownMenu = document.getElementById('dropdown-menu');

// Toggle dropdown saat ikon profil diklik
profileContainer.addEventListener('click', function () {
    if (dropdownMenu.style.display === 'block') {
        dropdownMenu.style.display = 'none';
    } else {
        dropdownMenu.style.display = 'block';
    }
});

// Sembunyikan dropdown saat klik di luar elemen
window.addEventListener('click', function (e) {
    if (!profileContainer.contains(e.target)) {
        dropdownMenu.style.display = 'none';
    }
});

// Ambil elemen yang dibutuhkan
const profilContainer = document.getElementById('profil-container');
const setProfilContainer = document.getElementById('set-profil-container');
const editButton = document.getElementById('edit-button');
const cancelButton = document.getElementById('cancel-button');

// Event ketika tombol Edit Profil ditekan
editButton.addEventListener('click', () => {
    profilContainer.style.display = 'none';
    setProfilContainer.style.display = 'flex';
});

// Event ketika tombol Batal ditekan
cancelButton.addEventListener('click', () => {
    setProfilContainer.style.display = 'none';
    profilContainer.style.display = 'flex';
});

function confirmLogout(event) {
    const confirmAction = confirm("Apakah Anda yakin ingin keluar?");
    if (!confirmAction) {
        event.preventDefault(); // Mencegah navigasi jika pengguna memilih "Cancel"
    }
}