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

$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$losis = $_POST['losis'];
$losis_angkutan = $_POST['losis_angkutan'];
$nama_barang = $_POST['nama_barang'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
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

		move_uploaded_file($tmp_name, '../file_administrasi/' . $nama_file_baru   );

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

        if($kode_perta == '2P.323.208' && $nama_barang == 'Pertamax'){
            
            	$query = mysqli_query($koneksi,"INSERT INTO pembelian VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga','$losis','$losis_angkutan','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal + $qty) - $losis;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == '2P.323.208' && $nama_barang == 'Dexlite'){
                $query = mysqli_query($koneksi,"INSERT INTO pembelian VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga','$losis','$losis_angkutan','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
               $stok_baru = ($stok_awal + $qty) - $losis;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO pembelian VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga','$losis','$losis_angkutan','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal + $qty) - $losis;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO pembelian VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga','$losis','$losis_angkutan','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
               $stok_baru = ($stok_awal + $qty) - $losis;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }
        else if($kode_perta == 'muaradua' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO pembelian VALUES ('','$tanggal','$kode_perta','$nama_barang','$qty','$harga','$losis','$losis_angkutan','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal + $qty) - $losis;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                	if ($query != "") {
				echo "<script> window.location='../view/VPembelian';</script>";exit;
		       	}
        }




		
