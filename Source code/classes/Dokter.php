<?php // Mulai definisi kelas

class Dokter extends DB // Mendefinisikan kelas Dokter yang merupakan turunan dari kelas DB
{
    function getDokter() // Fungsi untuk mengambil semua data dokter
    {
        $query = "SELECT * FROM Dokter"; // Query SQL untuk mengambil semua data dokter
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function getDokterById($id) // Fungsi untuk mengambil data dokter berdasarkan ID
    {
        $query = "SELECT * FROM Dokter WHERE ID_Dokter=$id"; // Query SQL untuk mengambil data dokter berdasarkan ID
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function addDokter($data) // Fungsi untuk menambahkan data dokter baru
    {
        $query = "INSERT INTO Dokter (Nama_Dokter, Photo, Spesialisasi, Nomor_Telepon, Alamat, Jadwal_Praktek, Informasi_Lain) 
                  VALUES ('".$data['Nama_Dokter']."', '".$data['Photo']."', '".$data['Spesialisasi']."', '".$data['Nomor_Telepon']."', '".$data['Alamat']."', '".$data['Jadwal_Praktek']."', '".$data['Informasi_Lain']."')"; // Query SQL untuk menambahkan data dokter baru

        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function sortDokter($type){
        $query = "SELECT * FROM Dokter Order By Nama_Dokter $type";
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function updateDokter($id, $data) // Fungsi untuk memperbarui data dokter
    {
        $query = "UPDATE Dokter SET "; // Query SQL untuk memperbarui data dokter
        foreach ($data as $key => $value) {
            $query .= "$key = '$value', "; // Mengonstruksi bagian SET dari query
        }
        $query = rtrim($query, ", "); // Menghapus koma dan spasi terakhir dari query
        $query .= " WHERE ID_Dokter = $id"; // Menambahkan klausa WHERE untuk menentukan dokter yang akan diperbarui
        
        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function deleteDokter($id) // Fungsi untuk menghapus data dokter berdasarkan ID
    {
        // Periksa apakah ada janji temu yang terkait dengan dokter
        $query_check = "SELECT COUNT(*) AS appointment_count FROM Appointment WHERE ID_Dokter = $id"; // Query SQL untuk menghitung jumlah janji temu terkait dengan dokter
        $this->execute($query_check); // Menjalankan query
        $result = $this->getResult(); // Mengambil hasil query
        $appointment_count = $result['appointment_count']; // Mendapatkan jumlah janji temu terkait

        if ($appointment_count > 0) { // Jika ada janji temu terkait
            // Tampilkan pesan kesalahan
            echo "<script>alert('Dokter tidak dapat dihapus karena memiliki janji temu yang terdaftar.');</script>";
            return false; // Mengembalikan false untuk menandakan bahwa penghapusan gagal
        } else { // Jika tidak ada janji temu terkait
            // Lanjutkan dengan penghapusan
            $query_delete = "DELETE FROM Dokter WHERE ID_Dokter = $id"; // Query SQL untuk menghapus data dokter
            $this->executeAffected($query_delete); // Menjalankan query penghapusan
            return true; // Mengembalikan true untuk menandakan bahwa penghapusan berhasil
        }
    }

    function searchDokter($keyword) // Fungsi untuk mencari dokter berdasarkan kata kunci
    {
        $query = "SELECT * FROM Dokter WHERE Nama_Dokter LIKE '%$keyword%' OR Spesialisasi LIKE '%$keyword%' OR Nomor_Telepon LIKE '%$keyword%'"; // Query SQL untuk mencari dokter berdasarkan nama atau spesialisai
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }
}
?>
