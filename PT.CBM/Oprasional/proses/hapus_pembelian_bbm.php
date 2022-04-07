
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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pembelian = $_POST['no_pembelian'];
$jumlah = $_POST['jumlah'];
$jenis_bbm = $_POST['jenis_bbm'];



        	
			
                if($jenis_bbm == 'Dexlite'){
                             
                    $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Dexlite' ");
                    $data_stok = mysqli_fetch_array($result2);
                    $stok_awal = $data_stok['stok'];
                    
                    $stok_baru = $stok_awal - $jumlah;
                    
                    $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Dexlite'");
                    $query = mysqli_query($koneksi,"DELETE FROM pembelian_bbm WHERE no_pembelian = '$no_pembelian'");
                    
                    echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                
                }
                else if($jenis_bbm == 'Pertamax'){
                    $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertamax' ");
                    $data_stok = mysqli_fetch_array($result2);
                    $stok_awal = $data_stok['stok'];
                    
                    $stok_baru = $stok_awal - $jumlah;
                    
                    $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertamax'");
                    $query = mysqli_query($koneksi,"DELETE FROM pembelian_bbm WHERE no_pembelian = '$no_pembelian'");
                    
                    echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                }
                else if($jenis_bbm == 'Pertalite'){
                
                    $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertalite' ");
                    $data_stok = mysqli_fetch_array($result2);
                    $stok_awal = $data_stok['stok'];
                    
                    $stok_baru = $stok_awal - $jumlah;
                    
                    $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertalite'");
                    $query = mysqli_query($koneksi,"DELETE FROM pembelian_bbm WHERE no_pembelian = '$no_pembelian'");
                    
                    echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                }
                else if($jenis_bbm == 'Solar'){
                    $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Solar' ");
                    $data_stok = mysqli_fetch_array($result2);
                    $stok_awal = $data_stok['stok'];
                    
                    $stok_baru = $stok_awal - $jumlah;
                    
                    $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Solar'");
                    $query = mysqli_query($koneksi,"DELETE FROM pembelian_bbm WHERE no_pembelian = '$no_pembelian'");
                    
                    echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

                }
			