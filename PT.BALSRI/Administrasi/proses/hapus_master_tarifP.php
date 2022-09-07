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


$delivery_point = $_POST['delivery_point'];



    
        

        //Hapusriwayat keberangkatan
        $query = mysqli_query($koneksi,"DELETE FROM master_tarif_p WHERE delivery_point = '$delivery_point'");


			echo "<script>alert('Data Berhasil di Hapus :)'); window.location='../view/VMasterTarifP';</script>";exit;



  ?>