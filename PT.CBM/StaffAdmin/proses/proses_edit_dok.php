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
if ($jabatan_valid == 'Staff Admin') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal = date('Y-m-d');
$nama_dokumen = $_POST['nama_dokumen'];
$no_rak = $_POST['no_rak'];
$referensi = $_POST['referensi'];
$keterangan = $_POST['keterangan'];
$no_dokumen = $_POST['no_dokumen'];
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

		move_uploaded_file($tmp_name, '../file_staff_admin/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE dokumen SET tanggal = '$tanggal' , nama_dokumen = '$nama_dokumen' , no_rak = '$no_rak' , referensi = '$referensi' , keterangan = '$keterangan'  WHERE no_dokumen = '$no_dokumen'");;
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE dokumen SET tanggal = '$tanggal' , nama_dokumen = '$nama_dokumen' , no_rak = '$no_rak' , referensi = '$referensi' , keterangan = '$keterangan', file_bukti = '$file'  WHERE no_dokumen = '$no_dokumen'");
	}





			echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VDokumen';</script>";exit;



  ?>