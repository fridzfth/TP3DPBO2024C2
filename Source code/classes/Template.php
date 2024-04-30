<?php // Mulai definisi kelas

class Template // Mendefinisikan kelas Template
{
    var $filename = ''; // Variabel untuk menyimpan nama file template
    var $content = ''; // Variabel untuk menyimpan konten template

    function __construct($filename = '') // Konstruktor kelas Template dengan parameter nama file
    {
        $this->filename = $filename; // Mengatur nilai variabel filename

        $this->content = implode('', @file($filename)); // Menggabungkan isi file template menjadi string
    }

    function clear() // Fungsi untuk membersihkan konten template
    {
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content); // Menghapus pola tertentu dari konten template
    }

    function write() // Fungsi untuk menulis konten template ke output
    {
        $this->clear(); // Memanggil fungsi clear untuk membersihkan konten
        print $this->content; // Mencetak konten template
    }

    function getContent() // Fungsi untuk mendapatkan konten template yang telah dibersihkan
    {
        $this->clear(); // Memanggil fungsi clear untuk membersihkan konten
        return $this->content; // Mengembalikan konten template yang telah dibersihkan
    }

    function replace($old = '', $new = '') // Fungsi untuk mengganti pola dalam konten template dengan nilai baru
    {
        if (is_int($new)) { // Jika nilai baru adalah integer
            $value = sprintf("%d", $new); // Mengonversi nilai baru menjadi format integer
        } elseif (is_float($new)) { // Jika nilai baru adalah float
            $value = sprintf("%f", $new); // Mengonversi nilai baru menjadi format float
        } elseif (is_array($new)) { // Jika nilai baru adalah array
            $value = ''; // Inisialisasi variabel untuk menyimpan nilai baru

            foreach ($new as $item) { // Iterasi melalui setiap elemen array baru
                $value .= $item . ' '; // Menambahkan setiap elemen array baru ke variabel nilai
            }
        } else { // Jika nilai baru bukan integer, float, atau array
            $value = $new; // Menggunakan nilai baru langsung
        }
        $this->content = preg_replace("/$old/", $value, $this->content); // Mengganti pola lama dengan nilai baru dalam konten template
    }
} // Akhir dari definisi kelas Template
?>
