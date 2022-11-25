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
if ($jabatan_valid == 'Admin Semen') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal_do = $_POST['tanggal_do'];
$tanggal_kirim = $_POST['tanggal_kirim'];
$no_do = $_POST['no_do'];
if($no_do == ''){
    
}
else{
$result = mysqli_query($koneksi, "SELECT * FROM penjualan_sl WHERE no_do = '$no_do' ");
 if(mysqli_num_rows($result) == 1 ){
  	echo "<script>alert('DO sudah tercatat :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }
}
$no_polisi = $_POST['no_polisi'];
$driver = $_POST['driver'];
$tujuan_pengiriman = $_POST['tujuan_pengiriman'];
$qty = $_POST['qty'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$toko_do = $_POST['toko_do'];
$tempo = $_POST['tempo'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$status_bayar = $_POST['status_bayar'];
$keterangan = $_POST['keterangan'];
$catatan = $_POST['catatan'];
$bulan = $_POST['bulan'];
$nama_file = $_FILES['file']['name'];
if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file']['name'];
		$ukuran_file = $_FILES['file']['size'];
		$error = $_FILES['file']['error'];
		$tmp_name = $_FILES['file']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin_semen/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


	$query = mysqli_query($koneksi,"INSERT INTO penjualan_sl VALUES('','$tanggal_do','$tanggal_kirim','$no_do','$driver','$no_polisi','$tujuan_pengiriman','$qty','$satuan','$harga','$jumlah','$toko_do','$tempo','$tanggal_bayar','$status_bayar'
		,'$keterangan','$catatan','$bulan','$file')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>