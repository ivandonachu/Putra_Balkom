
<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Admin Workshop') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];

$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$kendaraan = $_POST['kendaraan'];
$stock_awal = $_POST['stock_awal'];
$refill = $_POST['refill'];
$restock = $_POST['restock'];
$stock_akhir = $stock_awal - $refill + $restock;

	
			
	
            
            	$query = mysqli_query($koneksi,"INSERT INTO penggunaan_bbm VALUES ('','$tanggal','$nama_driver','$kendaraan','$stock_awal','$refill','$restock','$stock_akhir')");
              
                	if ($query != "") {
				echo "<script> window.location='../view/VPenggunaanBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
   