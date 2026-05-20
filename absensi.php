<?php
class Absensi {
    // ENKAPSULASI: Atribut absen juga wajib privat aman
    private $tanggal;
    private $status;

    public function __construct($tanggal, $status) {
        $this->tanggal = $tanggal;
        $this->status = $status;
    }

    public function getTanggal() {
        return $this->tanggal;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function updateStatus($conn, $nis, $statusBaru) {
        $this->setStatus($statusBaru); // Set data baru lewat fungsi internal
        $sql = "UPDATE absensi SET status = '$statusBaru' WHERE nis = '$nis'";
        return $conn->query($sql);
    }
}
?>