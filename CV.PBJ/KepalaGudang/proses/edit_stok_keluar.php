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

if ($jabatan_valid == 'KG Mesuji') {
    $kode_gudang = 'KG Mesuji';
} else if ($jabatan_valid == 'KG Way Kanan') {
    $kode_gudang = 'KG Way Kanan';
} else if ($jabatan_valid == 'KG Rantau Panjang') {
    $kode_gudang = 'KG Rantau Panjang';
} else if ($jabatan_valid == 'KG Unit 1') {
    $kode_gudang = 'KG Unit 1';
} else if ($jabatan_valid == 'KG MES') {
    $kode_gudang = 'KG MES';
} else if ($jabatan_valid == 'KG Simpang Sender') {
    $kode_gudang = 'KG Simpang Sender';
} else if ($jabatan_valid == 'KG Ruko M2') {
    $kode_gudang = 'KG Ruko M2';
} else if ($jabatan_valid == 'KG Kuto Sari') {
    $kode_gudang = 'KG Kuto Sari';
}else if ($jabatan_valid == 'KG BK 11') {
    $kode_gudang = 'KG BK 11';
} else {
    header("Location: logout.php");
    exit;
}

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$tanggal = $_POST['tanggal'];
$pembeli = $_POST['pembeli'];
$alamat = $_POST['alamat'];
$jenis_semen = $_POST['jenis_semen'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$jumlah = $harga * $qty;
$expenditur = $_POST['expenditur'];
$jenis_angkutan = $_POST['jenis_angkutan'];
$driver = $_POST['driver'];
$no_polisi = $_POST['no_polisi'];
$keterangan = $_POST['keterangan'];



	
			$query = mysqli_query($koneksi,"UPDATE laporan_stok_keluar_gudang SET  tanggal = '$tanggal', pembeli = '$pembeli', alamat = '$alamat' , jenis_semen = '$jenis_semen' , qty = '$qty', harga = '$harga', jumlah = '$jumlah' , expenditur = '$expenditur' , 
                                                                                  jenis_angkutan = '$jenis_angkutan' , driver = '$driver' , no_polisi = '$no_polisi'  , keterangan = '$keterangan' WHERE no_laporan = '$no_laporan'");


if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VStokKeluar?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>