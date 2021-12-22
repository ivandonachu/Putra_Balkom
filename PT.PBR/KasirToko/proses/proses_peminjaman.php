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
if ($jabatan_valid == 'Kasir') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$referensi = $_POST['referensi'];
$tanggal = $_POST['tanggal'];
$nama_baja = $_POST['nama_baja'];
$penyaluran = $_POST['penyaluran'];
$nama = $_POST['nama'];
$pembayaran = $_POST['pembayaran'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$jumlah = $_POST['jumlah'];
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

		move_uploaded_file($tmp_name, '../file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}




	if ($pembayaran=="Cash") {

		if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L03K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L03K01' ");

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
		else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}			
	
	else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B05K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B05K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
	else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
		else{echo "<script> alert('Gunakan pembayaran (-) untuk pinjam baja kosong!'); window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;}
}

	//Transfer
if ($pembayaran=="Transfer") {
	if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L03K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L03K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','5','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
	else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}			
	
	else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B05K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B05K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
	else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $jumlah;

		$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
		$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
		else{echo "<script> alert('Gunakan pembayaran (-) untuk pinjam baja kosong!'); window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;}
}
	//Bon
if ($pembayaran=="Bon") {
if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L03K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L03K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01'");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas piutang penjualan
		$status_piutang = 'Belum di Bayar'; 
		$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

	else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'L12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'L12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas piutang penjualan
		$status_piutang = 'Belum di Bayar'; 
		$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}			
	
	else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B05K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B05K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//aktivitas piutang penjualan
		$status_piutang = 'Belum di Bayar'; 
		$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
	else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
		$kode_akun = '4-110';
		$kode_baja = 'B12K11';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//BAJA + isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
		$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
		$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
		$jumlah_baja_isi_new2 = $jumlah_baja_isi2 - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;
		//pinjam
		$akses_inventory_pinjam2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
		$data_inventory_pinjam2 = mysqli_fetch_array($akses_inventory_pinjam2);
		$jumlah_baja_pinjam2 = $data_inventory_pinjam2['dipinjam'];
		$jumlah_baja_pinjam_new2 = $jumlah_baja_pinjam2 + $qty;
		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		$query10 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new2' WHERE kode_baja = 'B12K01' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		
		//aktivitas piutang penjualan
		$status_piutang = 'Belum di Bayar'; 
		$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
		else{echo "<script> alert('Gunakan pembayaran (-) untuk pinjam baja kosong!'); window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;}
}

if ($pembayaran=="-") {

	if ($nama_baja == "Elpiji 3 Kg Baja Kosong") {
		$kode_akun = '1-125';
		$kode_baja = 'L03K10';

		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;

		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
	
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
		
	else if ($nama_baja == "Elpiji 12 Kg Baja Kosong") {
		$kode_akun = '1-125';
		$kode_baja = 'L12K10';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;

		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

	
		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

	else if ($nama_baja == "Bright Gas 5,5 Kg Baja Kosong") {
		$kode_akun = '1-125';
		$kode_baja = 'B05K10';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;

		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	
	else if ($nama_baja == "Bright Gas 12 Kg Baja Kosong") {
		$kode_akun = '1-125';
		$kode_baja = 'B12K10';
		//riwayat penjualan
		$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
			'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
		$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
		$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
		$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//pinjam
		$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
		$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
		$jumlah_baja_pinjam_new = $jumlah_baja_pinjam + $qty;

		$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
		
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");

		//riwayat peminjaman
		$query8 = mysqli_query($koneksi,"INSERT INTO riwayat_peminjaman VALUES ('',00-00-0000,'$no_transaksi',0,'Belum Dikembalikan')");

		if ($query1!= "") {
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
		else{echo "<script> alert('Pembayaran (-) hanya untuk pinjam baja kosong!'); window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;}
}
