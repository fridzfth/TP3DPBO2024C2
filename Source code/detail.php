<?php

// Menggunakan file konfigurasi database dan memuat kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Dokter.php');
include('classes/Template.php');

// Membuat objek Dokter dan menghubungkan ke database
$Dokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Dokter->open();

// Menginisialisasi variabel data
$data = null;

// Jika terdapat parameter id pada URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        // Mendapatkan data dokter berdasarkan ID
        $Dokter->getDokterById($id);
        $row = $Dokter->getResult();

        // Membuat tampilan detail dokter
        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['Nama_Dokter'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['Photo'] . '" class="img-thumbnail" alt="' . $row['Nama_Dokter'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['Nama_Dokter'] . '</td>
                                </tr>
                                <tr>
                                    <td>Spesialisasi</td>
                                    <td>:</td>
                                    <td>' . $row['Spesialisasi'] . '</td>
                                </tr>
                                <tr>
                                    <td>No Telp</td>
                                    <td>:</td>
                                    <td>' . $row['Nomor_Telepon'] . '</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>' . $row['Alamat'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jadwal Praktek</td>
                                    <td>:</td>
                                    <td>' . $row['Jadwal_Praktek'] . '</td>
                                </tr>
                                <tr>
                                    <td>Informasi Tambahan</td>
                                    <td>:</td>
                                    <td>' . $row['Informasi_Lain'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="updatedokter.php?id=' . $id . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail.php?hapus=' . $id . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

// Jika terdapat parameter hapus pada URL
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Periksa apakah pengguna telah mengkonfirmasi penghapusan
        $confirmation = isset($_GET['confirm']) && $_GET['confirm'] === 'true';

        // Jika pengguna telah mengkonfirmasi penghapusan, lanjutkan dengan penghapusan data dokter
        if ($confirmation) {
            if ($Dokter->deleteDokter($id) > 0) {
                echo "<script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'detail.php?id=$id';
                </script>";
            }
        } else {
            // Jika pengguna belum mengkonfirmasi penghapusan, tampilkan dialog konfirmasi
            echo "<script>
                var confirmation = confirm('Apakah Anda yakin ingin menghapus data dokter ini?');
                if (confirmation) {
                    document.location.href = 'detail.php?hapus=$id&confirm=true';
                } else {
                    document.location.href = 'detail.php?id=$id';
                }
            </script>";
        }
    }
}

// Menutup koneksi database
$Dokter->close();

// Memuat template untuk tampilan detail
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_Dokter', $data);
$detail->write();
?>
