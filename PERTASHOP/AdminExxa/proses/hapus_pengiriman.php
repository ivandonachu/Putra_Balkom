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
$no_pengiriman = $_POST['no_pengiriman'];



	
		

		//Hapusriwayat keberangkatan
		
        
        $result = mysqli_query($koneksi, "SELECT * FROM pengiriman WHERE no_pengiriman = '$no_pengiriman' ");
        $data_pembelian = mysqli_fetch_array($result);
        $kode_perta = $data_pembelian['kode_perta'];
        $nama_barang = $data_pembelian['nama_barang'];
        $qty = $data_pembelian['qty'];
        
  
        
        
        if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'BK 3'){

            
            	$query = mysqli_query($koneksi,"DELETE FROM pengiriman WHERE no_pengiriman = '$no_pengiriman'");

                //PERTASHOP
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal + $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");


                //TUJUAN
                $result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
                $data_stok2 = mysqli_fetch_array($result3);
                $stok_awal = $data_stok2['stok'];
                
                $stok_baru = ($stok_awal - $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");

                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
		       	}
        }
        else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite' && $lokasi_kirim = 'Pul Baturaja'){
                $query = mysqli_query($koneksi,"DELETE FROM pengiriman WHERE no_pengiriman = '$no_pengiriman'");
                
                //PERTASHOP
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal + $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");


                //TUJUAN
                $result3 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
                $data_stok2 = mysqli_fetch_array($result3);
                $stok_awal = $data_stok2['stok'];
                
                $stok_baru = ($stok_awal - $qty);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPengiriman?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
		       	}
        }
       
	
		
	