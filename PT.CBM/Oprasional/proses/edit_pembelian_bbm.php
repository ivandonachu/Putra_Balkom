
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
        //data pembelian sebelum UPDATE
        $result = mysqli_query($koneksi, "SELECT jumlah FROM pembelian_bbm WHERE no_pembelian = '$no_pembelian' ");
        $data_pembelian = mysqli_fetch_array($result);
        $jumlah_lama = $data_pembelian['jumlah'];
			
			
			
        if($jenis_bbm == 'Dexlite'){
            
            	

                //update stok 
                $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Dexlite' ");
                $data_stok = mysqli_fetch_array($result2);
                $stok_awal = $data_stok['stok'];

                $stok_baru = $stok_awal - $jumlah_lama;

                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Dexlite'");

                

                if ($file == '') {
                    $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal'  WHERE no_pembelian  =  '$no_pembelian'");
                }
                else{
                    $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal' ,  file_bukti = '$file' WHERE no_pembelian  =  '$no_pembelian' ");
                }
               
                $result3 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Dexlite' ");
                $data_stok3 = mysqli_fetch_array($result3);
                $stok_awal = $data_stok3['stok'];

                $stok_baru = $stok_awal + $jumlah;

                $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Dexlite'");

                echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                    
        }
        else if($jenis_bbm == 'Pertamax'){

            //update stok 
            $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertamax' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];

            $stok_baru = $stok_awal - $jumlah_lama;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertamax'");

            

            if ($file == '') {
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal'  WHERE no_pembelian  =  '$no_pembelian'");
            }
            else{
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal' ,  file_bukti = '$file' WHERE no_pembelian  =  '$no_pembelian' ");
            }
           
            $result3 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertamax' ");
            $data_stok3 = mysqli_fetch_array($result3);
            $stok_awal = $data_stok3['stok'];

            $stok_baru = $stok_awal + $jumlah;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertamax'");

            echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                
              
        }
        else if($jenis_bbm == 'Pertalite'){

            //update stok 
            $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertalite' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];

            $stok_baru = $stok_awal - $jumlah_lama;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertalite'");

            

            if ($file == '') {
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal'  WHERE no_pembelian  =  '$no_pembelian'");
            }
            else{
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal' ,  file_bukti = '$file' WHERE no_pembelian  =  '$no_pembelian' ");
            }
           
            $result3 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Pertalite' ");
            $data_stok3 = mysqli_fetch_array($result3);
            $stok_awal = $data_stok3['stok'];

            $stok_baru = $stok_awal + $jumlah;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Pertalite'");

            echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                
             
        }
        else if($jenis_bbm == 'Solar'){

            //update stok 
            $result2 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Solar' ");
            $data_stok = mysqli_fetch_array($result2);
            $stok_awal = $data_stok['stok'];

            $stok_baru = $stok_awal - $jumlah_lama;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Solar'");

            

            if ($file == '') {
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal'  WHERE no_pembelian  =  '$no_pembelian'");
            }
            else{
                $query = mysqli_query($koneksi,"UPDATE pembelian_bbm SET tanggal = '$tanggal' , no_selang = '$no_selang' , no_nota = '$no_nota' , jenis_bbm = '$jenis_bbm' , harga = '$harga', jumlah = '$jumlah', total = '$total' , asal = '$asal' ,  file_bukti = '$file' WHERE no_pembelian  =  '$no_pembelian' ");
            }
           
            $result3 = mysqli_query($koneksi, "SELECT * FROM stok_bbm WHERE nama_bbm = 'Solar' ");
            $data_stok3 = mysqli_fetch_array($result3);
            $stok_awal = $data_stok3['stok'];

            $stok_baru = $stok_awal + $jumlah;

            $query2 = mysqli_query($koneksi,"UPDATE stok_bbm SET stok = '$stok_baru' WHERE nama_bbm = 'Solar'");

            echo "<script> window.location='../view/VPembelianBBM?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
                
        
    }
    