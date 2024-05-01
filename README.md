### Readme: Desain Program dan Penjelasan Alur Program
###### Janji : Saya Mohammad Faridz Fathin [2202680] mengerjakan TP3 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin. 

#### Desain Program

1. **Tujuan Program:**
    - Program ini bertujuan untuk mengelola data pasien, dokter, dan appointment (janji temu) dalam suatu sistem manajemen rumah sakit.

2. **Struktur Program:**
    - Program terdiri dari beberapa file PHP yang saling terkait dan menggunakan database MySQL untuk menyimpan data.

3. **Komponen Utama:**
    - **File Utama:**
        - Terdapat beberapa file utama yang mengatur alur program, seperti `index.php`, `pasien.php`, `dokter.php`, dan `appointment.php`. Ini adalah halaman-halaman yang menampilkan data pasien, dokter, dan appointment serta memberikan opsi untuk menambah, mengedit, atau menghapus data.

    - **Kelas:**
        - Terdapat beberapa kelas yang digunakan dalam program ini, seperti `DB`, `Pasien`, `Dokter`, dan `Appointment`. Kelas-kelas ini bertanggung jawab untuk melakukan operasi database seperti menambah, mengedit, menghapus, dan mengambil data.

    - **Template:**
        - Program menggunakan template HTML untuk mengatur tampilan halaman. File template ini berisi struktur HTML yang digunakan untuk setiap halaman, dengan placeholder yang digantikan dengan data dinamis.

    - **Formulir:**
        - Setiap halaman memiliki formulir yang memungkinkan pengguna untuk menambahkan atau mengedit data. Formulir ini menggunakan metode POST untuk mengirim data ke server.

    - **Database:**
        - Data pasien, dokter, dan appointment disimpan dalam tabel-tabel database MySQL. Program menggunakan kelas `DB` untuk mengatur koneksi ke database dan operasi database lainnya.

4. **Alur Kerja:**
    - Pengguna dapat mengakses halaman utama program seperti `index.php`, `pasien.php`, `dokter.php`, dan `appointment.php`.
    - Setiap halaman menampilkan data pasien, dokter, atau appointment dari database.
    - Pengguna dapat menambahkan, mengedit, atau menghapus data melalui formulir yang disediakan.
    - Setelah mengirimkan data melalui formulir, program akan memproses data tersebut menggunakan PHP dan menyimpannya ke database.
    - Jika operasi berhasil, pengguna akan diredirect ke halaman yang sesuai. Jika gagal, pesan kesalahan akan ditampilkan.

#### Penjelasan Alur Program

1. **Inisialisasi Database:**
    - Program menginisialisasi koneksi ke database MySQL menggunakan kelas `DB` dan file konfigurasi `config/db.php`.

2. **Halaman Utama:**
    - Pengguna dapat mengakses halaman utama program seperti `index.php`, `pasien.php`, `dokter.php`, dan `appointment.php`.
    - Setiap halaman ini menampilkan data dari database menggunakan kelas yang sesuai (`Pasien`, `Dokter`, `Appointment`).

3. **Formulir:**
    - Setiap halaman memiliki formulir yang memungkinkan pengguna untuk menambahkan, mengedit, atau menghapus data.
    - Formulir ini terhubung dengan file PHP yang sesuai untuk memproses data yang dikirim.

4. **Pengolahan Data:**
    - Ketika pengguna mengirimkan formulir, program akan menerima data melalui metode POST dan memprosesnya menggunakan PHP.
    - Data akan divalidasi dan disimpan ke database menggunakan kelas yang sesuai (`Pasien`, `Dokter`, `Appointment`).

5. **Tanggapan:**
    - Jika operasi berhasil, pengguna akan diredirect ke halaman yang sesuai dengan pesan sukses.
    - Jika operasi gagal, pesan kesalahan akan ditampilkan dan pengguna akan tetap berada di halaman yang sama.

6. **Penutup Database:**
    - Setelah selesai, program menutup koneksi ke database untuk menghemat sumber daya.


#### Dokumentasi

1. **Desain Database:**
    ![Desain Database](https://github.com/fridzfth/TP3DPBO2024C2/assets/140497713/1c1feba1-191d-44d5-9517-75f6735391a1)

2. Video Demo

https://github.com/fridzfth/TP3DPBO2024C2/assets/140497713/7e3c3f9b-2261-4508-b204-3b57bed2f2e1


#### Kesimpulan

Program ini memberikan fungsionalitas dasar untuk mengelola data pasien, dokter, dan appointment dalam suatu sistem manajemen rumah sakit. Dengan menggunakan PHP dan MySQL, program ini memungkinkan pengguna untuk menambahkan, mengedit, dan menghapus data dengan mudah melalui antarmuka web yang sederhana.
