<?php
class Siswa {
    // ENKAPSULASI: Atribut dikunci total pake private!
    private $nis;
    private $nama;

    public function __construct($nis, $nama) {
        $this->nis = $nis;
        $this->nama = $nama;
    }

    // GETTER: Jalur resmi buat ambil data NIS dari luar
    public function getNis() { 
        return $this->nis; 
    }

    // GETTER: Jalur resmi buat ambil data Nama
    public function getNama() {
        return $this->nama;
    }

    // SETTER: Jalur resmi buat validasi/ngubah data Nama
    public function setNama($nama) {
        $this->nama = $nama;
    }

    public function updateNama($conn, $namaBaru) {
        $this->setNama($namaBaru); // Mengubah di memori objek
        $sql = "UPDATE siswa SET nama = '$namaBaru' WHERE nis = '$this->nis'";
        return $conn->query($sql);
    }

    // METHOD STATIC: Tetap aman untuk query global
    public static function tambahSiswa($conn, $nis, $nama, $jurusan, $kelas) {
        $sql = "INSERT INTO siswa (nis, nama, jurusan, kelas) VALUES ('$nis', '$nama', '$jurusan', '$kelas')";
        return $conn->query($sql);
    }

    public static function hapusSiswa($conn, $nis) {
        $sql = "DELETE FROM siswa WHERE nis = '$nis'";
        return $conn->query($sql);
    }
}
?>