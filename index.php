<?php
session_start();
// 1. Koneksi Database Laragon
$conn = new mysqli("localhost", "root", "", "db_uas_dkv");

if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

// 2. Proteksi Role
if (!isset($_SESSION['role'])) { header("Location: login.php"); exit; }
if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit; }

require_once 'Siswa.php';
require_once 'siswaDKV.php';
require_once 'absensi.php';

// --- LOGIKA UPDATE DATA ---
if (isset($_POST['simpan_perubahan']) && $_SESSION['role'] == "Admin") {
    $nis = $_POST['nis_target']; 
    $nama_baru = $_POST['nama_update'];
    $status_baru = $_POST['status_update'];

    if (!empty($nis)) {
        $s = new SiswaDKV($nis, $nama_baru);
        $a = new Absensi(date("Y-m-d"), $status_baru);

        // Eksekusi fungsi update yang sudah privat & aman lewat enkapsulasi
        $s->updateNama($conn, $nama_baru);
        $a->updateStatus($conn, $nis, $status_baru);
    }
    
    header("Location: index.php"); 
    exit;
}

// --- LOGIKA TAMBAH SISWA ---
if (isset($_POST['tambah_siswa']) && $_SESSION['role'] == "Admin") {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    if (Siswa::tambahSiswa($conn, $nis, $nama, 'DKV', '12')) {
        $conn->query("INSERT INTO absensi (nis, tanggal, status) VALUES ('$nis', CURDATE(), 'Hadir')");
    }
    header("Location: index.php"); exit;
}

// --- LOGIKA HAPUS ---
if (isset($_GET['hapus']) && $_SESSION['role'] == "Admin") {
    Siswa::hapusSiswa($conn, $_GET['hapus']);
    header("Location: index.php"); exit;
}

// Ambil data dari database
$result = $conn->query("SELECT s.nis, s.nama, s.jurusan, s.kelas, a.status FROM siswa s LEFT JOIN absensi a ON s.nis = a.nis");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Absensi - SMK Diponegoro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body-utama">

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Panel Absensi Siswa 12 DKV</h2>
        <p>Role: <b><?= $_SESSION['role'] ?></b> | <a href="index.php?logout=true" style="color:red; text-decoration:none; font-weight:bold;">Logout ↩</a></p>
    </div>

    <?php if($_SESSION['role'] == "Admin"): ?>
    <form method="POST" style="background:#e8f5e9; padding:15px; border-radius:8px; margin-bottom:20px; display:flex; gap:10px;">
        <input type="text" name="nis" placeholder="NIS" required autocomplete="off" style="width:100px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
        <input type="text" name="nama" placeholder="Nama Lengkap" required autocomplete="off" style="flex:1; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" name="tambah_siswa" style="background:#4CAF50; color:white; border:none; padding:8px 15px; border-radius:4px; cursor:pointer; font-weight:bold;">+ Tambah</button>
    </form>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Jurusan & Kelas</th>
                <th>Status Kehadiran</th>
                <?php if($_SESSION['role'] == "Admin") echo "<th>Aksi</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = $result->fetch_assoc()): 
                // TAMENG OOP MURNI: Instansiasi data database langsung ke bentuk objek privat
                $siswa = new SiswaDKV($row['nis'], $row['nama']);
                $absensi = new Absensi(date("Y-m-d"), $row['status'] ?? 'Hadir');
            ?>
            <tr>
                <form method="POST">
                    <td>
                        <?= $siswa->getNis() ?>
                        <input type="hidden" name="nis_target" value="<?= $siswa->getNis() ?>">
                    </td>
                    <td>
                        <?php if($_SESSION['role'] == "Admin"): ?>
                            <input type="text" name="nama_update" value="<?= $siswa->getNama() ?>" autocomplete="off" style="padding:5px; width:90%; border: 1px solid #ccc; border-radius: 4px;">
                        <?php else: echo $siswa->getNama(); endif; ?>
                    </td>
                    <td><?= $siswa->getJurusan() ?> - <?= $siswa->getKelas() ?></td>
                    <td>
                        <?php if($_SESSION['role'] == "Admin"): ?>
                            <select name="status_update" style="padding:5px;">
                                <option value="Hadir" <?= $absensi->getStatus() == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="Izin" <?= $absensi->getStatus() == 'Izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="Sakit" <?= $absensi->getStatus() == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="Alpha" <?= $absensi->getStatus() == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                            </select>
                        <?php else: echo "<b>".$absensi->getStatus()."</b>"; endif; ?>
                    </td>
                    <?php if($_SESSION['role'] == "Admin"): ?>
                    <td>
                        <button type="submit" name="simpan_perubahan" class="btn-simpan">Simpan</button>
                        <a href="index.php?hapus=<?= $siswa->getNis() ?>" class="btn-hapus" onclick="return confirm('Hapus murid?')">Hapus</a>
                    </td>
                    <?php endif; ?>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>