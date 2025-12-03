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
if ($jabatan_valid == 'Kasir Semen') {

}

else{  header("Location: logout.php");
exit;
}

$no_penjualan = $_POST['no_penjualan'];
$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$tanggal_do = $_POST['tanggal_do'];
$tanggal_kirim = $_POST['tanggal_kirim'];
$no_do = $_POST['no_do'];
$driver = $_POST['driver'];
$no_polisi = $_POST['no_polisi'];
$tujuan_pengiriman = $_POST['tujuan_pengiriman'];
$qty = $_POST['qty'];
$satuan = $_POST['satuan'];
$harga_beli = $_POST['harga_beli'];
$harga = $_POST['harga'];
$jumlah = $qty * $harga;
$toko_do = $_POST['toko_do'];
$tempo = $_POST['tempo'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$status_bayar = $_POST['status_bayar'];
$keterangan = $_POST['keterangan'];
$catatan = $_POST['catatan'];
$bulan = $_POST['bulan'];


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

		move_uploaded_file($tmp_name, '../file_semen/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}


$result3 = mysqli_query($koneksi, "SELECT * FROM pengiriman_s WHERE no_penjualan = '$no_penjualan' ");
$data_perta = mysqli_fetch_array($result3);
$no_pengiriman = $data_perta['no_pengiriman'];


	if ($file == '') {
			$query3 = mysqli_query($koneksi,"UPDATE penjualan_s SET tanggal_do = '$tanggal_do' , tanggal_kirim = '$tanggal_kirim', no_do = '$no_do' , driver = '$driver' ,no_polisi = '$no_polisi' , 
			tujuan_pengiriman = '$tujuan_pengiriman' , qty = '$qty' , satuan = '$satuan' , harga_beli = '$harga_beli' , harga = '$harga' , jumlah = '$jumlah' , toko_do = '$toko_do' , tempo = '$tempo' , tanggal_bayar = '$tanggal_bayar' , 
			status_bayar = '$status_bayar' , keterangan = '$keterangan' , catatan = '$catatan'  , bulan = '$bulan' , kode_input = '$id1'  WHERE no_penjualan = '$no_penjualan'");

			$query4 = mysqli_query($koneksi,"UPDATE pengiriman_s SET no_do = '$no_do', driver = '$driver', no_polisi = '$no_polisi', 
			toko_do = '$toko_do' , kode_input = '$id1'  WHERE no_pengiriman = '$no_pengiriman'");
	}
	else{
			$query3 = mysqli_query($koneksi,"UPDATE penjualan_s SET tanggal_do = '$tanggal_do' , tanggal_kirim = '$tanggal_kirim', no_do = '$no_do' , driver = '$driver', no_polisi = '$no_polisi' , 
			tujuan_pengiriman = '$tujuan_pengiriman' , qty = '$qty' , satuan = '$satuan' , harga_beli = '$harga_beli' , harga = '$harga' , jumlah = '$jumlah' , toko_do = '$toko_do' , tempo = '$tempo' , tanggal_bayar = '$tanggal_bayar' , 
			status_bayar = '$status_bayar' , keterangan = '$keterangan' , catatan = '$catatan'  , bulan = '$bulan' , file_bukti = '$file'  , kode_input = '$id1'  WHERE no_penjualan = '$no_penjualan'");

			$query4 = mysqli_query($koneksi,"UPDATE pengiriman_s SET  no_do = '$no_do', driver = '$driver', no_polisi = '$no_polisi',
			toko_do = '$toko_do' , kode_input = '$id1'  WHERE no_pengiriman = '$no_pengiriman'");
	}


	echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/RincianPiutangR1?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&tujuan_pengiriman=$tujuan_pengiriman';</script>";exit;

?>