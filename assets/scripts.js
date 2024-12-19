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

document.getElementById('upload-avatar').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview-avatar').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
