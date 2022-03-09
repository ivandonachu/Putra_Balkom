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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_penjualan = $_POST['no_penjualan'];



	
		$result = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE no_penjualan = '$no_penjualan' ");
        $data_penjualan = mysqli_fetch_array($result);
        $kode_perta = $data_penjualan['kode_perta'];
        $nama_barang = $data_penjualan['nama_barang'];
        $qty = $data_penjualan['qty'];
        $ngecor = $data_penjualan['ngecor'];
   

		//Hapusriwayat keberangkatan
	


	
				
	    
			
        if($kode_perta == '2P.323.208' && $nama_barang == 'Pertamax'){
            
            	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + ($qty + $ngecor);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");

                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == '2P.323.208' && $nama_barang == 'Dexlite'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + ($qty + $ngecor);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + ($qty + $ngecor);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + ($qty + $ngecor);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Pertamax'){
           

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + ($qty + $ngecor);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }