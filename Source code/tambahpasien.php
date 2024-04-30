<?php   
// Memuat file konfigurasi database dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Pasien.php');
include('classes/Template.php');

// Membuat objek Pasien dan membuka koneksi database
$Pasien = new Pasien($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Pasien->open();

// Judul halaman dan nama halaman
$title = 'Tambah Pasien';
$page = 'pasien';
$view = new Template('templates/skinform.html');

// Mendefinisikan struktur formulir
$form = '<form action="tambahpasien.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>      
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="informasi_lain" class="form-label">Informasi Tambahan</label>
                <input type="text" class="form-control" id="informasi_lain" name="informasi_lain">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>';

// Memproses data yang dikirimkan melalui formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirim melalui formulir
    $data = array(
        'Nama' => $_POST['nama'],
        'Tanggal_Lahir' => $_POST['tanggal_lahir'],
        'Jenis_Kelamin' => $_POST['jenis_kelamin'],
        'Nomor_Telepon' => $_POST['nomor_telepon'],
        'Alamat' => $_POST['alamat'],
        'Informasi_Lain' => $_POST['informasi_lain']
    );

    // Panggil metode addPasien untuk menyimpan data ke database
    $result = $Pasien->addPasien($data);

    // Periksa apakah penambahan berhasil
    if ($result > 0) {
        echo "<script>
            alert('Pasien berhasil ditambahkan!');
            window.location.href = 'pasien.php'; // Redirect ke halaman lain setelah berhasil ditambahkan
        </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan Pasien!');
            window.location.href = 'tambahpasien.php'; // Kembali ke halaman formulir jika gagal
        </script>";
    }
}

// Menutup koneksi database
$Pasien->close();

// Mengganti tag placeholder pada template dengan data yang sudah disiapkan
$view->replace('FORM_TAMBAH_DATA', $form);
$view->replace('TITLE_FORM_LABEL', $title);
$view->replace('DATA_JUDUL_HALAMAN', "Pasien");
$view->replace('PAGE', $page);
$view->write();
?>
