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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_laporan = $_POST['no_laporan'];
$amt = $_POST['amt'];
$mt = $_POST['mt'];
$akun = $_POST['akun'];
$jml_pengeluaran = $_POST['jml_pengeluaran'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];
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

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

if($amt == ''){
    $no_driver = 0;
}

else{
    $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$amt' ");
$data_driver = mysqli_fetch_array($result);
$no_driver = $data_driver['no_driver'];
}

if($mt ==''){
    $no_kendaraan = 0;
}
else{
    
$result2 = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
$data_kendaraan = mysqli_fetch_array($result2);
$no_kendaraan = $data_kendaraan['no_kendaraan'];
}

$result3 = mysqli_query($koneksi, "SELECT * FROM kode_akun WHERE nama_akun = '$akun' ");
$data_akun = mysqli_fetch_array($result3);
$kode_akun = $data_akun['kode_akun'];

	if ($file == '') {
			$query = mysqli_query($koneksi,"UPDATE riwayat_perbaikan SET  kode_akun = '$kode_akun' , no_driver = '$no_driver' , no_kendaraan = '$no_kendaraan' , jumlah = '$jml_pengeluaran' , status =  '$status' ,keterangan = '$keterangan'  WHERE no_laporan = '$no_laporan'");
	}
	else{
			$query = mysqli_query($koneksi,"UPDATE riwayat_perbaikan SET kode_akun = '$kode_akun'  , no_driver = '$no_driver' , no_kendaraan = '$no_kendaraan' , jumlah = '$jml_pengeluaran', status =  '$status' , keterangan = '$keterangan' , file_bukti = '$file'  WHERE no_laporan = '$no_laporan'");
	}

if ($query != "") {
	echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VPerbaikan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

}

?>