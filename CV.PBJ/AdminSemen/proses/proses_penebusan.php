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
$tanggal = $_POST['tanggal'];
$no_do = $_POST['no_do'];
if($no_do == ''){
    
}
else{
$result = mysqli_query($koneksi, "SELECT * FROM pembelian_sl WHERE no_do = '$no_do' ");
 if(mysqli_num_rows($result) == 1 ){
  	echo "<script>alert('DO sudah tercatat :)'); window.location='../view/VPenebusan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }
}
$no_polisi = $_POST['no_polisi'];
$driver = $_POST['driver'];
$tujuan = $_POST['tujuan'];
$tipe_semen = $_POST['tipe_semen'];
$qty = $_POST['qty'];
$material = $_POST['material'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$nama_kota = $_POST['nama_kota'];
$tipe_bayar = $_POST['tipe_bayar'];
$tempo = $_POST['tempo'];
$keterangan = $_POST['keterangan'];
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

	$resultx = mysqli_query($koneksi, "SELECT * FROM list_kota_l WHERE nama_kota = '$nama_kota' ");
	$data_kota = mysqli_fetch_array($resultx);
	$tarif_pranko = $data_kota['tarif_pranko'];


	$query = mysqli_query($koneksi,"INSERT INTO pembelian_sl VALUES('','$tanggal','$no_do','$tipe_semen','$tujuan','$nama_kota','$tarif_pranko','$material','$qty','$harga','$jumlah','$driver','$no_polisi','$tipe_bayar', '$tempo','$keterangan','$file')");

			if ($query != "") {
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPenebusan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

  ?>