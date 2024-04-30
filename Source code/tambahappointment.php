<?php   
// Memuat file konfigurasi database dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Dokter.php');
include('classes/Pasien.php');
include('classes/Appointment.php');
include('classes/Template.php');

// Membuat objek Appointment dan membuka koneksi database
$Appointment = new Appointment($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Appointment->open();

// Judul halaman dan nama halaman
$title = 'Tambah Appointment';
$page = 'appointment';

// Mendapatkan data Pasien
$Pasien = new Pasien($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Pasien->open();
$PasienOptions = '';
$Pasien->getPasien();
while ($row = $Pasien->getResult()) {
    $PasienOptions .= '<option value="' . $row['ID_Pasien'] . '">' . $row['Nama'] . '</option>';
}
$Pasien->close();

// Mendapatkan data Dokter
$Dokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Dokter->open();
$DokterOptions = '';
$Dokter->getDokter();
while ($row = $Dokter->getResult()) {
    $DokterOptions .= '<option value="' . $row['ID_Dokter'] . '">' . $row['Nama_Dokter'] . '</option>';
}
$Dokter->close();

// Mengatur tampilan template untuk formulir
$view = new Template('templates/skinform.html');

// Mendefinisikan struktur formulir
$form = '<form action="tambahappointment.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="Pasien" class="form-label">Pasien</label>
                <select class="form-select" id="Pasien" name="Pasien" required>
                    <option selected disabled>Pilih Pasien</option>'
                    . $PasienOptions . 
                '</select>
            </div>
            <div class="mb-3">
                <label for="Dokter" class="form-label">Dokter</label>
                <select class="form-select" id="Dokter" name="Dokter" required>
                    <option selected disabled>Pilih Dokter</option>'
                    . $DokterOptions . 
                '</select>
            </div>
            <div class="mb-3">
                <label for="tanggal_Appointment" class="form-label">Tanggal Appointment</label>
                <input type="date" class="form-control" id="tanggal_Appointment" name="tanggal_Appointment" required>
            </div>
            <div class="mb-3">
                <label for="jam_appointment" class="form-label">Jam Appointment</label>
                <input type="time" class="form-control" id="jam_appointment" name="jam_appointment" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div>                   
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>';

// Memproses data yang dikirimkan melalui formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai yang dikirimkan melalui formulir
    $data = array(
        'ID_Pasien' => $_POST['Pasien'],
        'ID_Dokter' => $_POST['Dokter'],
        'Tanggal_Perjanjian' => $_POST['tanggal_Appointment'],
        'Jam_Perjanjian' => $_POST['jam_appointment'],
        'Keterangan' => $_POST['keterangan']
    );

    // Memanggil metode addAppointment untuk menyimpan data ke database
    $result = $Appointment->addAppointment($data);

    // Memeriksa apakah penambahan berhasil
    if ($result > 0) {
        echo "<script>
            alert('Appointment berhasil ditambahkan!');
            window.location.href = 'appointment.php'; // Mengalihkan ke halaman lain setelah berhasil ditambahkan
        </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan appointment!');
            window.location.href = 'tambahappointment.php'; // Kembali ke halaman formulir jika gagal
        </script>";
    }
}

// Menutup koneksi database
$Appointment->close();

// Mengganti tag placeholder pada template dengan data yang sudah disiapkan
$view->replace('FORM_TAMBAH_DATA', $form);
$view->replace('TITLE_FORM_LABEL', $title);
$view->replace('DATA_JUDUL_HALAMAN', "Appointment");
$view->replace('PAGE', $page);
$view->write();
?>
