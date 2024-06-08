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
if ($jabatan_valid == 'Kepala Oprasional') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$rekening_1 = $_POST['rekening_1'];
$jumlah_saldo_1 = $_POST['jumlah_saldo_1'];
$rekening_2 = $_POST['rekening_2'];
$jumlah_saldo_2 = $_POST['jumlah_saldo_2'];
$rekening_3 = $_POST['rekening_3'];
$jumlah_saldo_3 = $_POST['jumlah_saldo_3'];
$rekening_4 = $_POST['rekening_4'];
$jumlah_saldo_4 = $_POST['jumlah_saldo_4'];
$rekening_5 = $_POST['rekening_5'];
$jumlah_saldo_5 = $_POST['jumlah_saldo_5'];
$rekening_6 = $_POST['rekening_6'];
$jumlah_saldo_6 = $_POST['jumlah_saldo_6'];

    if($jumlah_saldo_1 == ""){

    }
    else{
        $query1 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_1','$jumlah_saldo_1')");
    }
    
    if($jumlah_saldo_2 == ""){

    }
    else{
        $query2 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_2','$jumlah_saldo_2')");
    }
    
    if($jumlah_saldo_3 == ""){

    }
    else{
        $query3 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_3','$jumlah_saldo_3')");
    }
    
    if($jumlah_saldo_4 == ""){

    }
    else{
        $query4 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_4','$jumlah_saldo_4')");
    }
    
    if($jumlah_saldo_5 == ""){

    }
    else{
        $query5 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_5','$jumlah_saldo_5')");
    }
    
    if($jumlah_saldo_6 == ""){

    }
    else{
        $query6 = mysqli_query($koneksi,"INSERT INTO laporan_saldo_rekening VALUES ('','$tanggal','$rekening_6','$jumlah_saldo_6')");
    }



				echo "<script> window.location='../view/VLSaldoRekening?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			
