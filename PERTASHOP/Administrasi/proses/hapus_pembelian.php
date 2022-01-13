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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pembelian = $_POST['no_pembelian'];



	
		

		//Hapusriwayat keberangkatan
		
        
        $result = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
        $data_pembelian = mysqli_fetch_array($result);
        $kode_perta = $data_pembelian['kode_perta'];
        $nama_barang = $data_pembelian['nama_barang'];
        $qty = $data_pembelian['qty'];
  
        
        
        if($kode_perta == '2P.323.208' && $nama_barang == 'Pertamax'){
            
            	$query = mysqli_query($koneksi,"DELETE FROM pembelian WHERE no_pembelian = '$no_pembelian'");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty)  ;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == '2P.323.208' && $nama_barang == 'Dexlite'){
                $query = mysqli_query($koneksi,"DELETE FROM pembelian WHERE no_pembelian = '$no_pembelian'");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty)  ;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"DELETE FROM pembelian WHERE no_pembelian = '$no_pembelian'");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty) ;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"DELETE FROM pembelian WHERE no_pembelian = '$no_pembelian'");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty) ;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"DELETE FROM pembelian WHERE no_pembelian = '$no_pembelian'");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $qty)  ;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
	
		echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	