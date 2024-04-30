<?php // Mulai definisi kelas

class DB // Mendefinisikan kelas DB
{
    private $hostname; // Variabel untuk menyimpan nama host database
    private $username; // Variabel untuk menyimpan nama pengguna database
    private $password; // Variabel untuk menyimpan kata sandi database
    private $dbname; // Variabel untuk menyimpan nama database
    private $conn; // Variabel untuk menyimpan koneksi database
    private $result; // Variabel untuk menyimpan hasil query

    function __construct($hostname, $username, $password, $dbname) // Konstruktor kelas DB dengan parameter host, username, password, dan nama database
    {
        $this->hostname = $hostname; // Mengatur nilai variabel hostname
        $this->username = $username; // Mengatur nilai variabel username
        $this->password = $password; // Mengatur nilai variabel password
        $this->dbname = $dbname; // Mengatur nilai variabel dbname
    }

    function open() // Fungsi untuk membuka koneksi database
    {
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname); // Membuka koneksi menggunakan mysqli_connect
    }

    function execute($query) // Fungsi untuk mengeksekusi query
    {
        $this->result = mysqli_query($this->conn, $query); // Menyimpan hasil query dalam variabel result
    }

    function getResult() // Fungsi untuk mendapatkan hasil query
    {
        return mysqli_fetch_array($this->result); // Mengembalikan baris hasil query sebagai array asosiatif
    }

    function executeAffected($query = "") // Fungsi untuk mengeksekusi query yang mempengaruhi data
    {
        mysqli_query($this->conn, $query); // Mengeksekusi query
        return mysqli_affected_rows($this->conn); // Mengembalikan jumlah baris yang terpengaruh oleh operasi query sebelumnya
    }

    function close() // Fungsi untuk menutup koneksi database
    {
        mysqli_close($this->conn); // Menutup koneksi menggunakan mysqli_close
    }
} // Akhir dari definisi kelas DB
?>
