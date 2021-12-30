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
if ($jabatan_valid == 'Admin Kebun') {

}

else{  header("Location: logout.php");
exit;
}

$no_laporan = $_POST['no_laporan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_karyawan = $_POST['nama_karyawan'];
$box = $_POST['box'];
$berat = $_POST['berat'];
$harga = $_POST['harga'];
$pembagi = $_POST['pembagi'];
$upah_kotor = $_POST['upah_kotor'];
$oa = $_POST['oa'];
$b_kompor = $_POST['b_kompor'];
$upah_bersih = $_POST['upah_bersih'];
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

		move_uploaded_file($tmp_name, '../file_kebun/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}





	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE laporan_karet SET tanggal = '$tanggal' , nama_karyawan = '$nama_karyawan' , box_karet = '$box' , berat = '$berat' , 
            harga_karet = '$harga' , pembagi = '$pembagi' , upah_kotor = '$upah_kotor' , ongkos_angkut = '$oa' , bayar_kompor = '$b_kompor' , upah_bersih = '$upah_bersih' , keterangan = '$keterangan' 
            WHERE no_laporan = '$no_laporan'");
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE laporan_karet SET tanggal = '$tanggal' , nama_karyawan = '$nama_karyawan' , box_karet = '$box' , berat = '$berat' , 
            harga_karet = '$harga' , pembagi = '$pembagi' , upah_kotor = '$upah_kotor' , ongkos_angkut = '$oa' , bayar_kompor = '$b_kompor' , upah_bersih = '$upah_bersih' , keterangan = '$keterangan' 
             , file_bukti = '$file'  WHERE no_laporan = '$no_laporan'");
	}


echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VLKaret?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

?>