<?php

// Menggunakan file konfigurasi database
include('config/db.php');

// Memasukkan kelas-kelas yang diperlukan
include('classes/DB.php');
include('classes/Appointment.php');
include('classes/Template.php');

// Membuat objek Appointment dan menghubungkan ke database
$Appointment = new Appointment($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Appointment->open();

// Mengambil data appointment dengan join
$Appointment->getAppointmentJoin();

// Mengatur tampilan template
$view = new Template('templates/skintabel.html');

// Mendefinisikan judul utama dan header tabel
$mainTitle = 'Appointment';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Pasien</th>
<th scope="row">Dokter</th>
<th scope="row">Tanggal Appointment</th>
<th scope="row">Appointment Time</th>
<th scope="row">Keterangan</th>
<th scope="row">Aksi</th>
</tr>';

// Inisialisasi variabel data dan nomor urut
$data = null;
$no = 1;

// Label untuk form
$formLabel = 'appointment';

// Mengisi data ke dalam tabel
while ($div = $Appointment->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['Nama_Pasien'] . '</td>
    <td>' . $div['Nama_Dokter'] . '</td>
    <td>' . $div['Tanggal_Perjanjian'] . '</td>
    <td>' . $div['Jam_Perjanjian'] . '</td>
    <td>' . $div['Keterangan'] . '</td>

    <td style="font-size: 22px;">
        <a href="updateappointment.php?id=' . $div['ID_Appointment'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <a href="appointment.php?hapus=' . $div['ID_Appointment'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// Memproses update data appointment
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($Appointment->updateAppointment($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'appointment.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'appointment.php';
            </script>";
            }
        }

        // Mendapatkan data appointment berdasarkan ID
        $Appointment->getAppointmentById($id);
        $row = $Appointment->getResult();

        $dataUpdate = $row['Appointment_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// Memproses penghapusan data appointment
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Periksa apakah pengguna telah mengkonfirmasi penghapusan
        $confirmation = isset($_GET['confirm']) && $_GET['confirm'] === 'true';

        // Jika pengguna telah mengkonfirmasi penghapusan, lanjutkan dengan penghapusan data appointment
        if ($confirmation) {
            if ($Appointment->deleteAppointment($id) > 0) {
                echo "<script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'appointment.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'appointment.php';
                </script>";
            }
        } else {
            // Jika pengguna belum mengkonfirmasi penghapusan, tampilkan dialog konfirmasi
            echo "<script>
                var confirmation = confirm('Apakah Anda yakin ingin menghapus data appointment ini?');
                if (confirmation) {
                    document.location.href = 'appointment.php?hapus=$id&confirm=true';
                } else {
                    document.location.href = 'appointment.php';
                }
            </script>";
        }
    }
}

// Menutup koneksi database
$Appointment->close();

// Mengganti tag placeholder pada template dengan data yang sudah disiapkan
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('TAMBAH_TAMBAH', $formLabel);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
