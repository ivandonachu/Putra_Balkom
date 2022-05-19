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

$no_pembelian = $_POST['no_pembelian'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$no_polisi = $_POST['no_polisi'];
$driver = $_POST['driver'];
$no_do = $_POST['no_do'];
$tipe_semen = $_POST['tipe_semen'];
$tujuan = $_POST['tujuan'];
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

	
	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE pembelian_sl SET tanggal = '$tanggal', no_do = '$no_do', tipe_semen = '$tipe_semen', tujuan = '$tujuan', kota = '$nama_kota', material = '$material', 
			qty = '$qty', harga = '$harga', jumlah = '$jumlah', driver = '$driver', no_polisi = '$no_polisi', tipe_bayar = '$tipe_bayar', tempo = '$tempo', keterangan = '$keterangan' 
            WHERE no_pembelian = '$no_pembelian'");

	
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE pembelian_sl SET tanggal = '$tanggal', no_do = '$no_do', tipe_semen = '$tipe_semen', tujuan = '$tujuan', kota = '$nama_kota', material = '$material', 
			qty = '$qty', harga = '$harga', jumlah = '$jumlah', driver = '$driver', no_polisi = '$no_polisi', tipe_bayar = '$tipe_bayar', tempo = '$tempo', keterangan = '$keterangan'
            , file_bukti = '$file'  WHERE no_pembelian = '$no_pembelian'");

		
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPenebusan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>