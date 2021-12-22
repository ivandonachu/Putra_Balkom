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
if ($jabatan_valid == 'Kepala Gudang') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$posisi_bongkar = $_POST['posisi_bongkar'];
$uang_tambahan = $_POST['uang_tambahan'];
$keterangan = $_POST['keterangan'];
$L03K11 = $_POST['L03K11'];
$L03K00 = $_POST['L03K00'];
$L12K11 = 0;
$B05K11	= 0;
$B12K11 = 0;
$L12K00 = 0;
$B05K00	= 0;
$B12K00 = 0;
$status = $_POST['status'];
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

		move_uploaded_file($tmp_name, '../file_gudang/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}		


if ($status == 'Hanya Kamvas') {



		$result = mysqli_query($koneksi, "SELECT * FROM rute_driver WHERE posisi_bongkar = '$posisi_bongkar' ");
		$data_rute = mysqli_fetch_array($result);
		$jumlah = $data_rute['jumlah'];
		$tambahan = $data_rute['tambahan'];
		$tujuan_berangkat = $data_rute['tujuan_berangkat'];

		$total_UJ = $jumlah + $tambahan + $uang_tambahan;

		$result2 = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$nama_driver' ");
		$data_driver = mysqli_fetch_array($result2);
		$id_driver = $data_driver['id_driver'];

		//input riwayat keberangkatan
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_keberangkatan VALUES ('','$tanggal','$id_driver','$no_polisi','$posisi_bongkar','$tujuan_berangkat','$total_UJ','$L03K11','$L03K00','$L12K11','$L12K00','$B05K11','$B05K00','$B12K11','$B12K00','$status',1,'$keterangan','$file')");

		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $total_UJ;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	

}
if ($status == 'Kamvas + Pengisian') {
		$qty = $L03K11;
		$qty2 = $L03K00;
			//3KG
			//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty + $qty2;
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty + $qty2;
		//RETUR
		$akses_inventory_rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
		$data_inventory_rt = mysqli_fetch_array($akses_inventory_rt);
		$jumlah_baja_rt = $data_inventory_rt['gudang'];
		$jumlah_baja_rt_new = $jumlah_baja_rt - $qty2;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_rt_new' WHERE kode_baja = 'L03K00' ");

		$result = mysqli_query($koneksi, "SELECT * FROM rute_driver WHERE posisi_bongkar = '$posisi_bongkar' ");
		$data_rute = mysqli_fetch_array($result);
		$jumlah = $data_rute['jumlah'];
		$tambahan = $data_rute['tambahan'];
		$tujuan_berangkat = $data_rute['tujuan_berangkat'];

		$total_UJ = $jumlah + $tambahan + $uang_tambahan;

		$result2 = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$nama_driver' ");
		$data_driver = mysqli_fetch_array($result2);
		$id_driver = $data_driver['id_driver'];

		//input riwayat keberangkatan
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_keberangkatan VALUES ('','$tanggal','$id_driver','$no_polisi','$posisi_bongkar','$tujuan_berangkat','$total_UJ','$L03K11','$L03K00','$L12K11','$L12K00','$B05K11','$B05K00','$B12K11','$B12K00','$status',1,'$keterangan','$file')");


		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $total_UJ;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

		if ($query != "") {
			echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	

}




