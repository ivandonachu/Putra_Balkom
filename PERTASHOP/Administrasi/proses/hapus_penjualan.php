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
$no_penjualan = $_POST['no_penjualan'];
$lokasi = $_POST['lokasi'];


	
		$result = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE no_penjualan = '$no_penjualan' ");
        $data_penjualan = mysqli_fetch_array($result);
        $kode_perta = $data_penjualan['kode_perta'];
        $nama_barang = $data_penjualan['nama_barang'];
        $qty = $data_penjualan['qty'];

   

		//Hapusriwayat keberangkatan
	


	
				
	    
			
        if($kode_perta == 'nusabakti' && $nama_barang == 'Pertamax'){
            
            	

                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
        }
        else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite'){
                	

                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualanDex?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
                	

                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
                	

                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Pertamax'){
           
                $query = mysqli_query($koneksi,"DELETE FROM penjualan WHERE no_penjualan = '$no_penjualan'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
			}
        }