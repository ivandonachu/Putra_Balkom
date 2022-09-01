<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result = mysqli_query($koneksi, "SELECT * FROM akun_perta a INNER JOIN pertashop b on b.kode_perta = b.kode_perta WHERE id_kar_perta = '$id'");
$data = mysqli_fetch_array($result);
$nama = $data['nama'];
$lokasi = $data['lokasi'];

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$nama_barang = $_POST['nama_barang'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$jual = $_POST['jual'];
$stok_awal = $_POST['stok_awal'];
$stok_akhir = $_POST['stok_akhir'];
$sonding_awal = $_POST['sonding_awal'];
$sonding_akhir = $_POST['sonding_akhir'];
$sirkulasi = $_POST['sirkulasi'];
$harga = $_POST['harga'];
$nama_karyawan = $_POST['nama_karyawan'];
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

		move_uploaded_file($tmp_name, '../file_karyawan/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

$result = mysqli_query($koneksi, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];
	


			
			
			
        if($kode_perta == 'nusabakti' && $nama_barang == 'Pertamax'){
            
            	$query = mysqli_query($koneksi,"INSERT INTO penjualan VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$jual',0,'$harga','$stok_awal','$stok_akhir','$sonding_awal','$sonding_akhir','$sirkulasi','$keterangan','$file',0)");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - ($jual);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite'){
                $query = mysqli_query($koneksi,"INSERT INTO penjualan VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$jual',0,'$harga','$stok_awal','$stok_akhir','$sonding_awal','$sonding_akhir','$sirkulasi','$keterangan','$file',0)");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
               $stok_baru = $stok_awal - ($jual);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO penjualan VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$jual',0,'$harga','$stok_awal','$stok_akhir','$sonding_awal','$sonding_akhir','$sirkulasi','$keterangan','$file',0)");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - ($jual);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                if ($query != "") {
				echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Dexlite'){
               
	
		    	echo "<script>alert('Barang Belum tersedia :)'); window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO penjualan VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$jual',0,'$harga','$stok_awal','$stok_akhir','$sonding_awal','$sonding_akhir','$sirkulasi','$keterangan','$file',0)");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
               $stok_baru = $stok_awal - ($jual);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                if ($query != "") {
				echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Dexlite'){
               
	
		    	echo "<script>alert('Barang Belum tersedia :)'); window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Pertamax'){
               $query = mysqli_query($koneksi,"INSERT INTO penjualan VALUES ('','$tanggal','$kode_perta','$nama_karyawan','$nama_barang','$jual',0,'$harga','$stok_awal','$stok_akhir','$sonding_awal','$sonding_akhir','$sirkulasi','$keterangan','$file',0)");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - ($jual);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                if ($query != "") {
				echo "<script> window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Dexlite'){
               
	
		    	echo "<script>alert('Barang Belum tersedia :)'); window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		
        }
