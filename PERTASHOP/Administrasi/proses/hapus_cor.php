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
$no_cor = $_POST['no_cor'];



	
		$result = mysqli_query($koneksi, "SELECT * FROM ngecor WHERE no_cor = '$no_cor' ");
        $data_cor = mysqli_fetch_array($result);
        $lokasi_cor = $data_cor['lokasi_cor'];
        $nama_barang = $data_cor['nama_barang'];
        $jumlah = $data_cor['jumlah'];
   

		//Hapusriwayat keberangkatan

	    
			
        if($lokasi_cor == 'Nusa Bakti' && $nama_barang == 'Pertamax'){
            
            	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");
                $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
			}
        }
        else if($lokasi_cor == 'Nusa Bakti' && $nama_barang == 'Dexlite'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");
                $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
			}
        }
        else if($lokasi_cor == 'Bedilan' && $nama_barang == 'Pertamax'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");
                $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
			}
        }
        else if($lokasi_cor == 'Sumber Jaya' && $nama_barang == 'Pertamax'){
                	

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");
                $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
			}
        }
        else if($lokasi_cor == 'Muara Dua' && $nama_barang == 'Pertamax'){
           

                
                $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];
                
                $stok_baru = $stok_awal + $jumlah;
                
                $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");
                $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                	if ($query != "") {
				echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
			}
        }
        else if($lokasi_cor == 'BK 3' && $nama_barang == 'Pertamax'){
            
            	

                
            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '11' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = $stok_awal + $jumlah;
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '11'");
            $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                if ($query != "") {
            echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
        }
    }
    else if($lokasi_cor == 'BK 3' && $nama_barang == 'Dexlite'){
                

            
            $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];
            
            $stok_baru = $stok_awal + $jumlah;
            
            $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");
            $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
                if ($query != "") {
            echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
        }
    }
    else if($lokasi_cor == 'Pul Baturaja' && $nama_barang == 'Pertamax'){
            
            	

                
        $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '13' ");
        $data_stok = mysqli_fetch_array($result2);
        $stok_awal = $data_stok['stok'];
        
        $stok_baru = $stok_awal + $jumlah;
        
        $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '13'");
        $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
            if ($query != "") {
        echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorPertamax?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
    }
}
else if($lokasi_cor == 'Pul Baturaja' && $nama_barang == 'Dexlite'){
            

        
        $result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
        $data_stok = mysqli_fetch_array($result2);
        $stok_awal = $data_stok['stok'];
        
        $stok_baru = $stok_awal + $jumlah;
        
        $query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");
        $query = mysqli_query($koneksi,"DELETE FROM ngecor WHERE no_cor = '$no_cor'");
            if ($query != "") {
        echo "<script>alert('Data Berhasil Di Hapus :)'); window.location='../view/VCorDexlite?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi_cor';</script>";exit;
    }
} 