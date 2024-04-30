<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Dokter.php');
include('classes/Template.php');

// buat instance Dokter
$listDokter = new Dokter($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listDokter->open();
// tampilkan data Dokter
$listDokter->getDokter();

// cari Dokter
if (isset($_POST['btn-cari'])) {
    // methode mencari data Dokter
    $listDokter->searchDokter($_POST['cari']);
} else {
    // method menampilkan data Dokter
    $listDokter->getDokter();
}

$data = null;

// ambil data Dokter
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listDokter->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
    '<div class="card pt-4 px-2 pengurus-thumbnail">
    <a href="detail.php?id=' . $row['ID_Dokter'] . '">
        <div class="row justify-content-center">
            <img src="assets/images/' . $row['Photo'] . '" class="card-img-top" alt="' . $row['Nama_Dokter'] . '" style="width: 200px; height: 200px;">
        </div>
        <div class="card-body">
            <p class="card-text pengurus-nama my-0">' . $row['Nama_Dokter'] . '</p>
            <p class="card-text divisi-nama">' . $row['Spesialisasi'] . '</p>
            <p class="card-text jabatan-nama my-0">' . $row['Nomor_Telepon'] . '</p>
        </div>
    </a>
    </div>    
    </div>';
}

// tutup koneksi
$listDokter->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_Dokter', $data);
$home->write();
