<?php // Mulai definisi kelas

class Pasien extends DB // Mendefinisikan kelas Pasien yang merupakan turunan dari kelas DB
{
    function getPasien() // Fungsi untuk mengambil semua data pasien
    {
        $query = "SELECT * FROM Pasien"; // Query SQL untuk mengambil semua data pasien
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function getPasienById($id) // Fungsi untuk mengambil data pasien berdasarkan ID
    {
        $query = "SELECT * FROM Pasien WHERE ID_Pasien=$id"; // Query SQL untuk mengambil data pasien berdasarkan ID
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function addPasien($data) // Fungsi untuk menambahkan data pasien baru
    {
        $query = "INSERT INTO Pasien (Nama, Alamat, Nomor_Telepon, Tanggal_Lahir, Jenis_Kelamin, Informasi_Lain) 
                  VALUES ('".$data['Nama']."', '".$data['Alamat']."', '".$data['Nomor_Telepon']."', '".$data['Tanggal_Lahir']."', '".$data['Jenis_Kelamin']."', '".$data['Informasi_Lain']."')"; // Query SQL untuk menambahkan data pasien baru

        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function updatePasien($id, $data) // Fungsi untuk memperbarui data pasien
    {
        $query = "UPDATE Pasien SET "; // Query SQL untuk memperbarui data pasien
        foreach ($data as $key => $value) {
            $query .= "$key = '$value', "; // Mengonstruksi bagian SET dari query
        }
        $query = rtrim($query, ", "); // Menghapus koma dan spasi terakhir dari query
        $query .= " WHERE ID_Pasien = $id"; // Menambahkan klausa WHERE untuk menentukan pasien yang akan diperbarui
        
        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function deletePasien($id) // Fungsi untuk menghapus data pasien berdasarkan ID
    {
        // Periksa apakah ada janji temu yang terkait dengan pasien
        $query_check = "SELECT COUNT(*) AS appointment_count FROM Appointment WHERE ID_Pasien = $id"; // Query SQL untuk menghitung jumlah janji temu terkait dengan pasien
        $this->execute($query_check); // Menjalankan query
        $result = $this->getResult(); // Mengambil hasil query
        $appointment_count = $result['appointment_count']; // Mendapatkan jumlah janji temu terkait

        if ($appointment_count > 0) { // Jika ada janji temu terkait
            // Tampilkan pesan kesalahan
            echo "<script>alert('Pasien tidak dapat dihapus karena telah terdaftar pada janji temu.');</script>";
            return false; // Mengembalikan false untuk menandakan bahwa penghapusan gagal
        } else { // Jika tidak ada janji temu terkait
            // Lanjutkan dengan penghapusan
            $query_delete = "DELETE FROM Pasien WHERE ID_Pasien = $id"; // Query SQL untuk menghapus data pasien
            $this->executeAffected($query_delete); // Menjalankan query penghapusan
            return true; // Mengembalikan true untuk menandakan bahwa penghapusan berhasil
        }
    }

    function searchPasien($keyword) // Fungsi untuk mencari pasien berdasarkan kata kunci
    {
        $query = "SELECT * FROM Pasien WHERE Nama LIKE '%$keyword%'"; // Query SQL untuk mencari pasien berdasarkan nama
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }
}
?>
