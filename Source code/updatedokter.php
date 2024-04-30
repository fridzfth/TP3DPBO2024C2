<?php   
// Memuat file konfigurasi database dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Dokter.php');
include('classes/Template.php');

// Membuat objek Dokter dan membuka koneksi database
$Dokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Dokter->open();

// Judul halaman dan nama halaman
$title = 'Update Dokter';
$page = 'index';
$view = new Template('templates/skinform.html');

// Ambil ID dokter yang akan diupdate dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Jika ID dokter valid, ambil data dokter berdasarkan ID
if ($id > 0) {
    $Dokter->getDokterById($id);
    $row = $Dokter->getResult();

    // Isi nilai default pada form dengan data dokter yang sudah ada
    $form = '<form action="updatedokter.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="' . $id . '">
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Dokter</label>
            <input type="text" class="form-control" id="nama" name="nama" value="' . $row['Nama_Dokter'] . '" required>
        </div>
        <div class="mb-3">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="' . $row['Nomor_Telepon'] . '" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>' . $row['Alamat'] . '</textarea>
        </div>
        <div class="mb-3">
            <label for="spesialisasi" class="form-label">Spesialisasi</label>
            <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" value="' . $row['Spesialisasi'] . '" required>
        </div>
        <div class="mb-3">
            <label for="jadwal_praktek" class="form-label">Jadwal Praktek</label>
            <input type="text" class="form-control" id="jadwal_praktek" name="jadwal_praktek" value="' . $row['Jadwal_Praktek'] . '" required>
        </div>
        <div class="mb-3">
            <label for="informasi_lain" class="form-label">Informasi Tambahan</label>
            <input type="text" class="form-control" id="informasi_lain" name="informasi_lain" value="' . $row['Informasi_Lain'] . '">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';
}

// Jika form dikirimkan (method POST), proses untuk mengupdate data dokter
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];
    $informasi_lain = $_POST['informasi_lain'];

    // Periksa apakah pengguna mengunggah foto baru
    if ($_FILES['photo']['name'] != '') {
        // Jika ada, proses untuk mengupload foto baru
        $photo = $_FILES['photo']['name'];
        $photo_path = 'assets/images/' . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            // Panggil metode updateDokter dengan data foto baru
            $data = array(
                'Nama_Dokter' => $nama,
                'Nomor_Telepon' => $nomor_telepon,
                'Alamat' => $alamat,
                'Spesialisasi' => $spesialisasi,
                'Jadwal_Praktek' => $jadwal_praktek,
                'Photo' => $photo,
                'Informasi_Lain' => $informasi_lain
            );
        } else {
            // Tampilkan pesan kesalahan jika gagal mengupload foto
            echo "<script>
                alert('Gagal mengupload foto!');
                window.location.href = 'updatedokter.php?id=$id'; // Kembali ke halaman updatedokter.php jika gagal upload foto
            </script>";
        }
    } else {
        // Jika tidak ada foto baru diunggah, panggil metode updateDokter tanpa data foto
        $data = array(
            'Nama_Dokter' => $nama,
            'Nomor_Telepon' => $nomor_telepon,
            'Alamat' => $alamat,
            'Spesialisasi' => $spesialisasi,
            'Jadwal_Praktek' => $jadwal_praktek,
            'Informasi_Lain' => $informasi_lain
        );
    }

    // Panggil metode updateDokter untuk menyimpan perubahan data ke database
    $result = $Dokter->updateDokter($id, $data);

    // Periksa apakah update berhasil
    if ($result > 0) {
        echo "<script>
            alert('Data dokter berhasil diupdate!');
            window.location.href = 'index.php'; // Redirect ke halaman lain setelah berhasil diupdate
        </script>";
    } else {
        // Tampilkan pesan kesalahan jika gagal mengupdate data dokter
        echo "<script>
            alert('Gagal mengupdate data dokter!');
            window.location.href = 'updatedokter.php?id=$id'; // Kembali ke halaman updatedokter.php jika gagal
        </script>";
    }
}

// Menutup koneksi database
$Dokter->close();

// Mengganti tag placeholder pada template dengan data yang sudah disiapkan
$view->replace('FORM_TAMBAH_DATA', $form);
$view->replace('TITLE_FORM_LABEL', $title);
$view->replace('DATA_JUDUL_HALAMAN', "Dokter");
$view->replace('PAGE', $page);
$view->write();
?>
