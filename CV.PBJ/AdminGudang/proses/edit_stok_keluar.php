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
$pembeli = $_POST['pembeli'];
$alamat = $_POST['alamat'];
$jenis_semen = $_POST['jenis_semen'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$jumlah = $harga * $qty;
$keterangan = $_POST['keterangan'];



	
			$query = mysqli_query($koneksi,"UPDATE laporan_stok_keluar SET  tanggal = '$tanggal', nama_gudang = '$nama_gudang'  ,pembeli = '$pembeli', alamat = '$alamat' , jenis_semen = '$jenis_semen' , qty = '$qty', harga = '$harga', jumlah = '$jumlah' , keterangan = '$keterangan' WHERE no_laporan = '$no_laporan'");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VStokKeluarMasuk?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&nama_gudang=$nama_gudang';</script>";exit;

}
?>