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
$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal_kirim = $_POST['tanggal_kirim'];
$lokasi = $_POST['lokasi']; 
$lokasi_kirim = $_POST['lokasi_kirim'];
$no_so = $_POST['no_so'];
$nama_barang = $_POST['nama_barang'];
$qty = $_POST['qty'];
$keterangan = $_POST['keterangan'];

$result = mysqli_query($koneksi, "SELECT * FROM pengiriman WHERE no_so = '$no_so' AND tanggal_kirim = '$tanggal_kirim' ");
 if(mysqli_num_rows($result) == 1 ){
  	echo "<script>alert('SO Pengiriman sudah tercatat :)'); window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>"; exit;
      }

        
        
$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];

        if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'BK 3' ){
            
            	$query = mysqli_query($koneksi,"INSERT INTO PENGIRIMAN VALUES ('','$no_so','$tanggal_kirim','$kode_perta','$lokasi_kirim','$nama_barang','$qty','$keterangan')");
                
                //PERTASHOP
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");


                //TUJUAN
                $result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
                $data_stok2 = mysqli_fetch_array($result3);
                $stok_awal = $data_stok2['stok'];
                
                $stok_baru = ($stok_awal + $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");


                	if ($query != "") {
				echo "<script> window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
		       	}
        }
        else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'Pul Baturaja'){
                $query = mysqli_query($koneksi,"INSERT INTO PENGIRIMAN VALUES ('','$no_so','$tanggal_kirim','$kode_perta','$lokasi_kirim','$nama_barang','$qty','$keterangan')");
                
                //PERTASHOP
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");


                //TUJUAN
                $result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
                $data_stok2 = mysqli_fetch_array($result3);
                $stok_awal = $data_stok2['stok'];
                
                $stok_baru = ($stok_awal + $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
		       	}
        }
        



		
