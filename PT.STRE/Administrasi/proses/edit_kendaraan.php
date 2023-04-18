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
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}

$no = $_POST['no'];
$no_polisi = $_POST['no_polisi'];
$jenis_kendaraan = $_POST['jenis_kendaraan'];
$wilayah_operasi = $_POST['wilayah_operasi'];

$tanggal_stnk = $_POST['tanggal_stnk'];
$tanggal_tera_tangki = $_POST['tanggal_tera_tangki'];
$tanggal_tera_flowmeter = $_POST['tanggal_tera_flowmeter'];
$tanggal_kir = $_POST['tanggal_kir'];


//file stnk
$nama_file_stnk = $_FILES['file_stnk']['name'];
if ($nama_file_stnk == "") {
	$file_stnk = "";
}

else if ( $nama_file_stnk != "" ) {

	function upload(){
		$nama_file_stnk = $_FILES['file_stnk']['name'];
		$ukuran_file = $_FILES['file_stnk']['size'];
		$error = $_FILES['file_stnk']['error'];
		$tmp_name = $_FILES['file_stnk']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_stnk);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file_stnk = upload();
	if (!$file_stnk) {
		return false;
	}

}


//file_tera_tangki 
$nama_file_tera_tangki = $_FILES['file_tera_tangki']['name'];
if ($nama_file_tera_tangki == "") {
	$file_tera_tangki = "";
}

else if ( $nama_file_tera_tangki != "" ) {

	function upload1(){
		$nama_file_tera_tangki = $_FILES['file_tera_tangki']['name'];
		$ukuran_file = $_FILES['file_tera_tangki']['size'];
		$error = $_FILES['file_tera_tangki']['error'];
		$tmp_name = $_FILES['file_tera_tangki']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_tera_tangki);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file_tera_tangki = upload1();
	if (!$file_tera_tangki) {
		return false;
	}

}

//file_tera_flowmeter 
$nama_file_tera_flowmeter = $_FILES['file_tera_flowmeter']['name'];
if ($nama_file_tera_flowmeter == "") {
	$file_tera_flowmeter = "";
}

else if ( $nama_file_tera_flowmeter != "" ) {

	function upload2(){
		$nama_file_tera_flowmeter = $_FILES['file_tera_flowmeter']['name'];
		$ukuran_file = $_FILES['file_tera_flowmeter']['size'];
		$error = $_FILES['file_tera_flowmeter']['error'];
		$tmp_name = $_FILES['file_tera_flowmeter']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_tera_flowmeter);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file_tera_flowmeter = upload2();
	if (!$file_tera_flowmeter) {
		return false;
	}

}

//file_kir
$nama_file_kir = $_FILES['file_kir']['name'];
if ($nama_file_kir == "") {
	$file_kir = "";
}

else if ( $nama_file_kir != "" ) {

	function upload3(){
		$nama_file_kir = $_FILES['file_kir']['name'];
		$ukuran_file = $_FILES['file_kir']['size'];
		$error = $_FILES['file_kir']['error'];
		$tmp_name = $_FILES['file_kir']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_kir);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file_kir = upload3();
	if (!$file_kir) {
		return false;
	}

}



if ($file_stnk == '' && $file_tera_tangki == '' && $file_tera_flowmeter == '' && $file_kir == '' ) {
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi', tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
														 tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir'  WHERE no = '$no'");
}

else if($file_stnk != '' && $file_tera_tangki != '' && $file_tera_flowmeter != '' && $file_kir != ''){
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi', tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
														 tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir' ,  file_stnk = '$file_stnk' ,  file_tera_tangki = '$file_tera_tangki' 
														 ,  file_tera_flowmeter = '$file_tera_flowmeter' ,  file_kir = '$file_kir'  WHERE no = '$no'");
}



else if($file_stnk != ''){
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi' , tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
											tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir'  ,  file_stnk = '$file_stnk' WHERE no = '$no'");
}

else if($file_tera_tangki != ''){
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi' , tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
											tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir'  ,  file_tera_tangki = '$file_tera_tangki'  WHERE no = '$no'");
}

else if( $file_tera_flowmeter != ''){
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi' , tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
											tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir'  ,  file_tera_flowmeter = '$file_tera_flowmeter'  WHERE no = '$no'");
}

else if( $file_kir != ''){
	$query = mysqli_query($koneksi,"UPDATE kendaraan SET no_polisi = '$no_polisi' , jenis_kendaraan = '$jenis_kendaraan' , wilayah_operasi = '$wilayah_operasi' , tanggal_stnk = '$tanggal_stnk', tanggal_tera_tangki = '$tanggal_tera_tangki', 
											tanggal_tera_flowmeter = '$tanggal_tera_flowmeter', tanggal_kir = '$tanggal_kir'  ,  file_kir = '$file_kir' WHERE no = '$no'");
}






	
	
			echo "<script>alert('Data Proses Berhasil :)'); window.location='../view/VMT';</script>";exit;



  ?>