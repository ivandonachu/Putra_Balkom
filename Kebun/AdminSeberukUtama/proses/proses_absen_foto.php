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
if ($jabatan_valid == 'Admin Seberuk Utama') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];

//data 1
$nama_karyawan_1 = $_POST['nama_karyawan_1'];
$nama_file_1 = $_FILES['file1']['name'];
if ($nama_file_1 == "") {
	$file1 = "";
}

else if ( $nama_file_1 != "" ) {

	function upload(){
		$nama_file_1 = $_FILES['file1']['name'];
		$ukuran_file = $_FILES['file1']['size'];
		$error = $_FILES['file1']['error'];
		$tmp_name = $_FILES['file1']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_1);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

        move_uploaded_file($tmp_name, '../file_admin_seberuk/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file1 = upload();
	if (!$file1) {
		return false;
	}

}

//data 2
$nama_karyawan_2 = $_POST['nama_karyawan_2'];
$nama_file_2 = $_FILES['file2']['name'];
if ($nama_file_2 == "") {
	$file2 = "";
}

else if ( $nama_file_2 != "" ) {

	function upload2(){
		$nama_file_2 = $_FILES['file2']['name'];
		$ukuran_file = $_FILES['file2']['size'];
		$error = $_FILES['file2']['error'];
		$tmp_name = $_FILES['file2']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_2);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

		move_uploaded_file($tmp_name, '../file_admin_seberuk/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file2 = upload2();
	if (!$file2) {
		return false;
	}

}

//data 3
$nama_karyawan_3 = $_POST['nama_karyawan_3'];
$nama_file_3 = $_FILES['file3']['name'];
if ($nama_file_3 == "") {
	$file3 = "";
}

else if ( $nama_file_3 != "" ) {

	function upload3(){
		$nama_file_3 = $_FILES['file3']['name'];
		$ukuran_file = $_FILES['file3']['size'];
		$error = $_FILES['file3']['error'];
		$tmp_name = $_FILES['file3']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_3);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

        move_uploaded_file($tmp_name, '../file_admin_seberuk/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file3 = upload3();
	if (!$file3) {
		return false;
	}

}

//data 4
$nama_karyawan_4 = $_POST['nama_karyawan_4'];
$nama_file_4 = $_FILES['file4']['name'];
if ($nama_file_4 == "") {
	$file4 = "";
}

else if ( $nama_file_4 != "" ) {

	function upload4(){
		$nama_file_4 = $_FILES['file4']['name'];
		$ukuran_file = $_FILES['file4']['size'];
		$error = $_FILES['file4']['error'];
		$tmp_name = $_FILES['file4']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_4);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

        move_uploaded_file($tmp_name, '../file_admin_seberuk/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file4 = upload4();
	if (!$file4) {
		return false;
	}

}

//data 5
$nama_karyawan_5 = $_POST['nama_karyawan_5'];
$nama_file_5 = $_FILES['file5']['name'];
if ($nama_file_5 == "") {
	$file5 = "";
}

else if ( $nama_file_5 != "" ) {

	function upload5(){
		$nama_file_5 = $_FILES['file5']['name'];
		$ukuran_file = $_FILES['file5']['size'];
		$error = $_FILES['file5']['error'];
		$tmp_name = $_FILES['file5']['tmp_name'];

		$ekstensi_valid = ['jpg','jpeg','pdf','doc','docs','xls','xlsx','docx','txt','png'];
		$ekstensi_file = explode(".", $nama_file_5);
		$ekstensi_file = strtolower(end($ekstensi_file));


		$nama_file_baru = uniqid();
		$nama_file_baru .= ".";
		$nama_file_baru .= $ekstensi_file;

        move_uploaded_file($tmp_name, '../file_admin_seberuk/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file5 = upload5();
	if (!$file5) {
		return false;
	}

}


    if($file1 != ""){
        $query = mysqli_query($koneksi,"INSERT INTO absensi_foto_seberuk VALUES ('','$tanggal','$nama_karyawan_1','$file1')");
    }
    else{

    }

    if($file2 != ""){
        $query2 = mysqli_query($koneksi,"INSERT INTO absensi_foto_seberuk VALUES ('','$tanggal','$nama_karyawan_2','$file2')");
    }
    else{

    }

    if($file3 != ""){
        $query3 = mysqli_query($koneksi,"INSERT INTO absensi_foto_seberuk VALUES ('','$tanggal','$nama_karyawan_3','$file3')");
    }
    else{

    }

    if($file4 != ""){
        $query4 = mysqli_query($koneksi,"INSERT INTO absensi_foto_seberuk VALUES ('','$tanggal','$nama_karyawan_4','$file4')");
    }
    else{

    }

    if($file5 != ""){
        $query5 = mysqli_query($koneksi,"INSERT INTO absensi_foto_seberuk VALUES ('','$tanggal','$nama_karyawan_5','$file5')");
    }
    else{

    }
	

   
   
    


			if ($query != "") {
				echo "<script> window.location='../view/VAbsenFoto?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
