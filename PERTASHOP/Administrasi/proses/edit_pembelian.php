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
$no_pembelian = $_POST['no_pembelian'];
$tanggal = $_POST['tanggal'];
$tanggal_bongkar = $_POST['tanggal_bongkar'];
$lokasi = $_POST['lokasi'];
$lokasi_bongkar = $_POST['lokasi_bongkar'];
$no_so = $_POST['no_so'];
$volume_tangki = $_POST['volume_tangki'];
$sonding_awal = $_POST['sonding_awal'];
$sonding_akhir = $_POST['sonding_akhir'];
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

if($kode_perta == 'nusabakti' && $nama_barang == 'Pertamax'){
            
	
	
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '6' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '6'");

}
else if($kode_perta == 'nusabakti' && $nama_barang == 'Dexlite'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '7' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '7'");

}
else if($kode_perta == 'bedilan' && $nama_barang == 'Pertamax'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '8' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '8'");

}
else if($kode_perta == 'sumberjaya' && $nama_barang == 'Pertamax'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '9' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '9'");

}
else if($kode_perta == 'muaradua' && $nama_barang == 'Dexlite'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '10' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '10'");

}
else if($kode_perta == 'bk3' && $nama_barang == 'Pertamax'){
            
	
	
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '11' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '11'");

}
else if($kode_perta == 'bk3' && $nama_barang == 'Dexlite'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '12' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '12'");

}
if($kode_perta == 'pul_bta' && $nama_barang == 'Pertamax'){
            
	
	
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '13' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '13'");

}
else if($kode_perta == 'pul_bta' && $nama_barang == 'Dexlite'){
	$result2 = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang = '14' ");
	$data_stok = mysqli_fetch_array($result2);
	$stok_awal = $data_stok['stok'];

	$result3 = mysqli_query($koneksi, "SELECT qty FROM pembelian WHERE no_pembelian = '$no_pembelian' ");
	$data_pembelian = mysqli_fetch_array($result3);
	$qty_pembelian = $data_pembelian['qty'];
	
	$stok_baru = (($stok_awal - $qty_pembelian) + $qty);
	
	$query2 = mysqli_query($koneksi,"UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '14'");

}
    
    if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE pembelian SET no_so = '$no_so', tanggal = '$tanggal',tanggal_bongkar = '$tanggal_bongkar' , lokasi_bongkar = '$lokasi_bongkar' , kode_perta = '$kode_perta' , nama_barang = '$nama_barang', qty = '$qty' , harga = '$harga', volume_tangki = '$volume_tangki'
		 ,sonding_awal = '$sonding_awal',sonding_akhir = '$sonding_akhir',keterangan = '$keterangan'  WHERE no_pembelian = '$no_pembelian'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE pembelian SET no_so = '$no_so', tanggal = '$tanggal' , tanggal_bongkar = '$tanggal_bongkar' , lokasi_bongkar = '$lokasi_bongkar' , kode_perta = '$kode_perta' , nama_barang = '$nama_barang', qty = '$qty' , harga = '$harga', volume_tangki = '$volume_tangki'
		,sonding_awal = '$sonding_awal',sonding_akhir = '$sonding_akhir',keterangan = '$keterangan' ,  file_bukti = '$file' WHERE no_pembelian = 
		'$no_pembelian'");
	}
	


		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPembelian?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi';</script>";exit;
