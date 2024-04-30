<?php   
// Memuat file konfigurasi database dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Appointment.php');
include('classes/Dokter.php');
include('classes/Pasien.php');
include('classes/Template.php');

// Membuat objek Appointment dan membuka koneksi database
$Appointment = new Appointment($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Appointment->open();

// Judul halaman dan nama halaman
$title = 'Update Appointment';
$page = 'appointment';


$view = new Template('templates/skinform.html');

// Ambil ID appointment yang akan diupdate
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Jika ID appointment valid, ambil data appointment berdasarkan ID
if ($id > 0) {

    $Appointment->getAppointmentById($id);
    $row = $Appointment->getResult();

    // Mendapatkan data Pasien
    $Pasien = new Pasien($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $Pasien->open();
    $PasienOptions = '';
    $Pasien->getPasien();
    while ($rowPasien = $Pasien->getResult()) {
        $selectedPasien = ($rowPasien['ID_Pasien'] == $row['ID_Pasien']) ? 'selected' : '';
        $PasienOptions .= '<option value="' . $rowPasien['ID_Pasien'] . '" ' . $selectedPasien . '>' . $rowPasien['Nama'] . '</option>';
    }
    $Pasien->close();

    // Mendapatkan data Dokter
    $Dokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $Dokter->open();
    $DokterOptions = '';
    $Dokter->getDokter();
    while ($rowDokter = $Dokter->getResult()) {
        $selectedDokter = ($rowDokter['ID_Dokter'] == $row['ID_Dokter']) ? 'selected' : '';
        $DokterOptions .= '<option value="' . $rowDokter['ID_Dokter'] . '" ' . $selectedDokter . '>' . $rowDokter['Nama_Dokter'] . '</option>';
    }
    $Dokter->close();

    // Isi nilai default pada form dengan data appointment yang sudah ada
    $form = '<form action="updateappointment.php" method="POST">
        <input type="hidden" name="id" value="' . $id . '">
        <div class="mb-3">
            <label for="Pasien" class="form-label">Pasien</label>
            <select class="form-select" id="Pasien" name="Pasien" required>'
                . $PasienOptions .
            '</select>
        </div>
        <div class="mb-3">
            <label for="Dokter" class="form-label">Dokter</label>
            <select class="form-select" id="Dokter" name="Dokter" required>'
                . $DokterOptions .
            '</select>
        </div>
        <div class="mb-3">
            <label for="tanggal_Appointment" class="form-label">Tanggal Appointment</label>
            <input type="date" class="form-control" id="tanggal_Appointment" name="tanggal_Appointment" value="' . $row['Tanggal_Perjanjian'] . '" required>
        </div>
        <div class="mb-3">
            <label for="jam_appointment" class="form-label">Jam Appointment</label>
            <input type="time" class="form-control" id="jam_appointment" name="jam_appointment" value="' . $row['Jam_Perjanjian'] . '" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="' . $row['Keterangan'] . '" required>
        </div>                   
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';
}

// Jika form dikirimkan (method POST), proses untuk mengupdate data appointment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $pasien_id = $_POST['Pasien'];
    $dokter_id = $_POST['Dokter'];
    $tanggal_Appointment = $_POST['tanggal_Appointment'];
    $jam_appointment = $_POST['jam_appointment'];
    $keterangan = $_POST['keterangan'];

    // Panggil metode updateAppointment untuk menyimpan perubahan data ke database
    $data = array(
        'ID_Pasien' => $pasien_id,
        'ID_Dokter' => $dokter_id,
        'Tanggal_Perjanjian' => $tanggal_Appointment,
        'Jam_Perjanjian' => $jam_appointment,
        'Keterangan' => $keterangan
    );

    $result = $Appointment->updateAppointment($id, $data);

    // Periksa apakah update berhasil
    if ($result > 0) {
        echo "<script>
            alert('Data appointment berhasil diupdate!');
            window.location.href = 'appointment.php'; // Redirect ke halaman lain setelah berhasil diupdate
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengupdate data appointment!');
            window.location.href = 'updateappointment.php?id=$id'; // Kembali ke halaman updateappointment.php jika gagal
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
