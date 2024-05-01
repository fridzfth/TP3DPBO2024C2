<?php

// Menggunakan file konfigurasi database dan memuat kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Pasien.php');
include('classes/Template.php');

// Membuat objek Pasien dan menghubungkan ke database
$Pasien = new Pasien($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Pasien->open();

// Mendapatkan data pasien
$Pasien->getPasien();

// Mengatur tampilan template
$view = new Template('templates/skintabel.html');

// Mendefinisikan judul utama dan header tabel
$mainTitle = 'Pasien';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Pasien</th>
<th scope="row">Tanggal Lahir</th>
<th scope="row">Jenis Kelamin</th>
<th scope="row">Nomor Telepon</th>
<th scope="row">Alamat</th>
<th scope="row">Info Tambahan</th>
<th scope="row">Aksi</th>
</tr>';

// Inisialisasi variabel data dan nomor urut
$data = null;
$no = 1;

// Label untuk form
$formLabel = 'pasien';

// Mengisi data ke dalam tabel
while ($div = $Pasien->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['Nama'] . '</td>
    <td>' . $div['Tanggal_Lahir'] . '</td>
    <td>' . $div['Jenis_Kelamin'] . '</td>
    <td>' . $div['Nomor_Telepon'] . '</td>
    <td>' . $div['Alamat'] . '</td>
    <td>' . $div['Informasi_Lain'] . '</td>

    <td style="font-size: 22px;">
        <a href="updatepasien.php?id=' . $div['ID_Pasien'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="pasien.php?hapus=' . $div['ID_Pasien'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// Memproses update data pasien
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($Pasien->updatePasien($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'pasien.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'pasien.php';
            </script>";
            }
        }

        // Mendapatkan data pasien berdasarkan ID
        $Pasien->getPasienById($id);
        $row = $Pasien->getResult();

        $dataUpdate = $row['Pasien_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// Memproses penghapusan data pasien
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Periksa apakah pengguna telah mengkonfirmasi penghapusan
        $confirmation = isset($_GET['confirm']) && $_GET['confirm'] === 'true';

        // Jika pengguna telah mengkonfirmasi penghapusan, lanjutkan dengan penghapusan data pasien
        if ($confirmation) {
            if ($Pasien->deletePasien($id) > 0) {
                echo "<script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'pasien.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'pasien.php';
                </script>";
            }
        } else {
            // Jika pengguna belum mengkonfirmasi penghapusan, tampilkan dialog konfirmasi
            echo "<script>
                var confirmation = confirm('Apakah Anda yakin ingin menghapus data pasien ini?');
                if (confirmation) {
                    document.location.href = 'pasien.php?hapus=$id&confirm=true';
                } else {
                    document.location.href = 'pasien.php';
                }
            </script>";
        }
    }
}

// Menutup koneksi database
$Pasien->close();

// Mengganti tag placeholder pada template dengan data yang sudah disiapkan
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('TAMBAH_TAMBAH', $formLabel);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();