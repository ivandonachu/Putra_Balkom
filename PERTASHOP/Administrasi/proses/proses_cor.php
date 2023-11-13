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
$tanggal = $_POST['tanggal'];
$tanggal_pembayaran = $_POST['tanggal_pembayaran'];
$lokasi_cor = $_POST['lokasi_cor'];
$no_polisi = $_POST['no_polisi'];
$nama_driver = $_POST['nama_driver'];
$nm_pt = $_POST['nm_pt'];
$nama_barang = $_POST['nama_barang'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
$total = $jumlah * $harga;
$jenis_cor = $_POST['jenis_cor'];
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
        
        


        if($lokasi_cor == 'Nusa Bakti' && $nama_barang == 'Pertamax'){
            
            	$query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $jumlah);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");
                	if ($query != "") {
				echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
		       	}
        }
        else if($lokasi_cor == 'Nusa Bakti' && $nama_barang == 'Dexlite'){
                $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $jumlah);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                	if ($query != "") {
				echo "<script> window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
		       	}
        }
        else if($lokasi_cor == 'Bedilan' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $jumlah);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                	if ($query != "") {
				echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
		       	}
        }
        else if($lokasi_cor == 'Sumber Jaya' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");
                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $jumlah);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                	if ($query != "") {
				echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
		       	}
        }
        else if($lokasi_cor == 'Muara Dua' && $nama_barang == 'Pertamax'){
                $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");

                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = ($stok_awal - $jumlah);
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                	if ($query != "") {
				echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
		       	}
        }
        else if($lokasi_cor == 'BK 3' && $nama_barang == 'Pertamax'){
            $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");

            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '11' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = ($stok_awal - $jumlah);
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '11'");
                if ($query != "") {
            echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
               }
        }

        else if($lokasi_cor == 'BK 3' && $nama_barang == 'Dexlite'){
            $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");

            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = ($stok_awal - $jumlah);
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");
                if ($query != "") {
            echo "<script> window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
            }
        }

        else if($lokasi_cor == 'Pul Baturaja' && $nama_barang == 'Pertamax'){
            $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");

            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '13' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = ($stok_awal - $jumlah);
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '13'");
                if ($query != "") {
            echo "<script> window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
            }
        }    
        else if($lokasi_cor == 'Pul Baturaja' && $nama_barang == 'Dexlite'){
            $query = mysqli_query($koneksi,"INSERT INTO ngecor VALUES ('','$tanggal','$tanggal_pembayaran','$lokasi_cor','$no_polisi','$nama_driver','$nm_pt','$nama_barang','$jumlah','$harga','$total','$jenis_cor','$keterangan','$file')");

            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = ($stok_awal - $jumlah);
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");
                if ($query != "") {
            echo "<script> window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
            }
        }           




		
