<?php
require_once 'Siswa.php';

// INHERITANCE: Anak (SiswaDKV) mewarisi Bapak (Siswa)
class SiswaDKV extends Siswa {
    // ENKAPSULASI: Atribut spesifik anak juga di-private
    private $jurusan = "DKV";
    private $kelas = "12";

    public function getJurusan() {
        return $this->jurusan;
    }

    public function getKelas() {
        return $this->kelas;
    }

    public function tampilkanData() {
        // KARENA ENKAPSULASI: Gak bisa panggil $this->nama langsung, 
        // Wajib panggil fungsi Getter dari class Bapak ($this->getNama())
        return "Siswa: " . $this->getNama() . " (" . $this->getNis() . ") | Jurusan: " . $this->jurusan;
    }
}
?>