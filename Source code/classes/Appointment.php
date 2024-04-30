<?php // Mulai definisi kelas

class Appointment extends DB // Mendefinisikan kelas Appointment yang merupakan turunan dari kelas DB
{
    function getAppointmentJoin() // Fungsi untuk mengambil data perjanjian dengan informasi dokter dan pasien yang terhubung
    {
        $query = "SELECT 
        Appointment.ID_Appointment,
        Appointment.ID_Pasien AS Pasien_ID,
        Appointment.ID_Dokter AS Dokter_ID,
        Appointment.Tanggal_Perjanjian,
        Appointment.Jam_Perjanjian,
        Appointment.Keterangan,
        Dokter.Nama_Dokter AS Nama_Dokter,
        Dokter.Photo AS Photo_Dokter,
        Dokter.Spesialisasi AS Spesialisasi_Dokter,
        Dokter.Nomor_Telepon AS Nomor_Telepon_Dokter,
        Dokter.Alamat AS Alamat_Dokter,
        Dokter.Jadwal_Praktek AS Jadwal_Praktek_Dokter,
        Pasien.Nama AS Nama_Pasien,
        Pasien.Alamat AS Alamat_Pasien,
        Pasien.Nomor_Telepon AS Nomor_Telepon_Pasien,
        Pasien.Tanggal_Lahir AS Tanggal_Lahir_Pasien,
        Pasien.Jenis_Kelamin AS Jenis_Kelamin_Pasien,
        Pasien.Informasi_Lain AS Informasi_Lain_Pasien
    FROM 
        Appointment
    JOIN 
        Dokter ON Appointment.ID_Dokter = Dokter.ID_Dokter
    JOIN 
        Pasien ON Appointment.ID_Pasien = Pasien.ID_Pasien
    ORDER BY 
        Appointment.ID_Appointment"; // Query SQL untuk mengambil data perjanjian dengan informasi dokter dan pasien yang terhubung

        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function getAppointment() // Fungsi untuk mengambil semua data perjanjian
    {
        $query = "SELECT * FROM Appointment"; // Query SQL untuk mengambil semua data perjanjian
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function getAppointmentById($id) // Fungsi untuk mengambil data perjanjian berdasarkan ID
    {
        $query = "SELECT * FROM Appointment WHERE ID_Appointment=$id"; // Query SQL untuk mengambil data perjanjian berdasarkan ID
        return $this->execute($query); // Menjalankan query dan mengembalikan hasilnya
    }

    function addAppointment($data) // Fungsi untuk menambahkan data perjanjian baru
    {
        $query = "INSERT INTO Appointment (ID_Pasien, ID_Dokter, Tanggal_Perjanjian, Jam_Perjanjian, Keterangan) 
          VALUES (".$data['ID_Pasien'].", ".$data['ID_Dokter'].", '".$data['Tanggal_Perjanjian']."', '".$data['Jam_Perjanjian']."', '".$data['Keterangan']."')"; // Query SQL untuk menambahkan data perjanjian baru

        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function updateAppointment($id, $data) // Fungsi untuk memperbarui data perjanjian
    {
        $query = "UPDATE Appointment SET "; // Query SQL untuk memperbarui data perjanjian
        foreach ($data as $key => $value) {
            $query .= "$key = '$value', "; // Mengonstruksi bagian SET dari query
        }
        $query = rtrim($query, ", "); // Menghapus koma dan spasi terakhir dari query
        $query .= " WHERE ID_Appointment = $id"; // Menambahkan klausa WHERE untuk menentukan perjanjian yang akan diperbarui
        
        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }

    function deleteAppointment($id){ // Fungsi untuk menghapus data perjanjian berdasarkan ID
        $query = "DELETE FROM Appointment WHERE ID_Appointment = $id"; // Query SQL untuk menghapus data perjanjian berdasarkan ID
        return $this->executeAffected($query); // Menjalankan query dan mengembalikan jumlah baris yang terpengaruh
    }
}
?>
