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
$title = 'Tambah Dokter';
$page = 'index';

// Mengatur tampilan template untuk formulir
$view = new Template('templates/skinform.html');

// Mendefinisikan struktur formulir
$form = '<form action="tambahdokter.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Dokter</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
            <div class="mb-3">
                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" required>
            </div>
            <div class="mb-3">
                <label for="jadwal_praktek" class="form-label">Jadwal Praktek</label>
                <input type="text" class="form-control" id="jadwal_praktek" name="jadwal_praktek" required>
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
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];
    $informasi_lain = $_POST['informasi_lain'];
    $photo = $_FILES['photo']['name'];

    // Proses upload foto
    $photo_path = 'assets/images/' . basename($_FILES['photo']['name']);
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
        // Panggil metode addDokter untuk menyimpan data ke database
        $data = array(
            'Nama_Dokter' => $nama,
            'Nomor_Telepon' => $nomor_telepon,
            'Alamat' => $alamat,
            'Spesialisasi' => $spesialisasi,
            'Jadwal_Praktek' => $jadwal_praktek,
            'Photo' => $photo,
            'Informasi_Lain' => $informasi_lain
        );

        $result = $Dokter->addDokter($data);

        // Periksa apakah penambahan berhasil
        if ($result > 0) {
            echo "<script>
                alert('Dokter berhasil ditambahkan!');
                window.location.href = 'index.php'; // Redirect ke halaman lain setelah berhasil ditambahkan
            </script>";
        } else {
            echo "<script>
                alert('Gagal menambahkan Dokter!');
                window.location.href = 'tambahdokter.php'; // Kembali ke halaman formulir jika gagal
            </script>";
        }
    } else {
        echo "<script>
            alert('Gagal mengupload foto!');
            window.location.href = 'tambahdokter.php'; // Kembali ke halaman formulir jika gagal upload foto
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
