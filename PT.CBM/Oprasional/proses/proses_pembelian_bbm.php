
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
$no_selang = $_POST['no_selang'];
$no_nota = $_POST['no_nota'];
$jenis_bbm = $_POST['jenis_bbm'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
$total = $_POST['total'];
$asal = $_POST['asal'];
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

		move_uploaded_file($tmp_name, '../file_oprasional/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

			
			
			
        if($jenis_bbm == 'Dexlite'){
            
            	$query = mysqli_query($koneksi,"INSERT INTO pembelian_bbm VALUES ('','$tanggal','$no_selang','$no_nota','$jenis_bbm','$harga','$jumlah','$total','$asal','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Dexlite' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Dexlite'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        }
        else if($jenis_bbm == 'Pertamax'){
            $query = mysqli_query($koneksi,"INSERT INTO pembelian_bbm VALUES ('','$tanggal','$no_selang','$no_nota','$jenis_bbm','$harga','$jumlah','$total','$asal','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertamax' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertamax'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
              
        }
        else if($jenis_bbm == 'Pertalite'){
            $query = mysqli_query($koneksi,"INSERT INTO pembelian_bbm VALUES ('','$tanggal','$no_selang','$no_nota','$jenis_bbm','$harga','$jumlah','$total','$asal','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertalite' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertalite'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
             
        }
        else if($jenis_bbm == 'Solar'){
            $query = mysqli_query($koneksi,"INSERT INTO pembelian_bbm VALUES ('','$tanggal','$no_selang','$no_nota','$jenis_bbm','$harga','$jumlah','$total','$asal','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Solar' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Solar'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
        
    }
    