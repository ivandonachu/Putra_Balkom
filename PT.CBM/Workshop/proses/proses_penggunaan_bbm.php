
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
if ($jabatan_valid == 'Admin Workshop') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];

$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$jenis_penggunaan = $_POST['jenis_penggunaan'];
$no_polisi = $_POST['no_polisi'];
$tujuan = $_POST['tujuan'];
$jenis_bbm = $_POST['jenis_bbm'];
$jumlah = $_POST['jumlah'];

	
			
			
        if($jenis_bbm == 'Dexlite'){
            
            	$query = mysqli_query($koneksi,"INSERT INTO penggunaan_bbm VALUES ('','$tanggal','$jenis_penggunaan','$nama_driver','$no_polisi','$tujuan','$jenis_bbm','$jumlah')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Dexlite' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Dexlite'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenggunaanBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($jenis_bbm == 'Pertamax'){
            $query = mysqli_query($koneksi,"INSERT INTO penggunaan_bbm VALUES ('','$tanggal','$jenis_penggunaan','$nama_driver','$no_polisi','$tujuan','$jenis_bbm','$jumlah')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertamax' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertamax'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenggunaanBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
              
        }
        else if($jenis_bbm == 'Pertalite'){
            $query = mysqli_query($koneksi,"INSERT INTO penggunaan_bbm VALUES ('','$tanggal','$jenis_penggunaan','$nama_driver','$no_polisi','$tujuan','$jenis_bbm','$jumlah')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertalite' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertalite'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenggunaanBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
             
        }
        else if($jenis_bbm == 'Solar'){
            $query = mysqli_query($koneksi,"INSERT INTO penggunaan_bbm VALUES ('','$tanggal','$jenis_penggunaan','$nama_driver','$no_polisi','$tujuan','$jenis_bbm','$jumlah')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Solar' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal - $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Solar'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPenggunaanBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        
    }
    