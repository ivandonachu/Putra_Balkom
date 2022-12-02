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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Kepala Gudang') {

}

else{  header("Location: logout.php");
exit;
}



$nama_file = $_FILES['file_profile']['name'];
if ($nama_file == "") {
	$file = "";
}

else if ( $nama_file != "" ) {

	function upload(){
		$nama_file = $_FILES['file_profile']['name'];
		$ukuran_file = $_FILES['file_profile']['size'];
		$error = $_FILES['file_profile']['error'];
		$tmp_name = $_FILES['file_profile']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','png'];
		$ekstensi_file = explode(".", $nama_file);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../../../assets/img/foto_profile/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}
    
   



            mysqli_query($koneksi,"UPDATE account SET foto_profile = '$file' WHERE id_karyawan =  '$id1' ");
        
        
       echo "<script>alert('Profil Berhasil Di Edit'); window.location='../view/VProfile';</script>";exit;

    




	
