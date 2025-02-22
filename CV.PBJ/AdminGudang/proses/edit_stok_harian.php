<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
    header("Location: logout.php");
    exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];

if ($jabatan_valid == 'Admin Gudang') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$nama_gudang = $_POST['nama_gudang'];
$tanggal = $_POST['tanggal'];
$nama_gudang = $_POST['nama_gudang'];
$jenis_semen = $_POST['jenis_semen'];
$stok_awal = $_POST['stok_awal'];
$stok_masuk = $_POST['stok_masuk'];
$stok_keluar = $_POST['stok_keluar'];
$stok_pecah_beku = $_POST['stok_pecah_beku'];
$stok_akhir = $_POST['stok_akhir'];
$keterangan = $_POST['keterangan'];



	
			$query = mysqli_query($koneksi,"UPDATE laporan_stok_harian SET  tanggal = '$tanggal', jenis_semen = '$jenis_semen' , stok_awal = '$stok_awal', stok_masuk = '$stok_masuk' , 
                                                stok_keluar = '$stok_keluar' , stok_pecah_beku = '$stok_pecah_beku', stok_akhir = '$stok_akhir' , keterangan = '$keterangan'  WHERE no_laporan = '$no_laporan'");


if ($query != "") {
echo "<script> window.location='../view/VStokHarian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama_gudang=$nama_gudang';</script>";exit;

}

?>