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
$title = 'Update Pasien';
$page = 'pasien';
$view = new Template('templates/skinform.html');

// Ambil ID pasien yang akan diupdate dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Jika ID pasien valid, ambil data pasien berdasarkan ID
if ($id > 0) {
    $Pasien->getPasienById($id);
    $row = $Pasien->getResult();

    // Isi nilai default pada form dengan data pasien yang sudah ada
    $form = '<form action="updatepasien.php" method="POST">
        <input type="hidden" name="id" value="' . $id . '">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" id="nama" name="nama" value="' . $row['Nama'] . '" required>
        </div>      
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="' . $row['Tanggal_Lahir'] . '" required>
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" ' . ($row['Jenis_Kelamin'] == 'Laki-laki' ? 'selected' : '') . '>Laki-laki</option>
                <option value="Perempuan" ' . ($row['Jenis_Kelamin'] == 'Perempuan' ? 'selected' : '') . '>Perempuan</option>
            </select>
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
            <label for="informasi_lain" class="form-label">Informasi Tambahan</label>
            <input type="text" class="form-control" id="informasi_lain" name="informasi_lain" value="' . $row['Informasi_Lain'] . '">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';
}

// Jika form dikirimkan (method POST), proses untuk mengupdate data pasien
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $informasi_lain = $_POST['informasi_lain'];

    // Panggil metode updatePasien untuk menyimpan perubahan data ke database
    $data = array(
        'Nama' => $nama,
        'Tanggal_Lahir' => $tanggal_lahir,
        'Jenis_Kelamin' => $jenis_kelamin,
        'Nomor_Telepon' => $nomor_telepon,
        'Alamat' => $alamat,
        'Informasi_Lain' => $informasi_lain
    );

    $result = $Pasien->updatePasien($id, $data);

    // Periksa apakah update berhasil
    if ($result > 0) {
        echo "<script>
            alert('Data pasien berhasil diupdate!');
            window.location.href = 'pasien.php'; // Redirect ke halaman lain setelah berhasil diupdate
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengupdate data pasien!');
            window.location.href = 'updatepasien.php?id=$id'; // Kembali ke halaman updatepasien.php jika gagal
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
