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

$tanggal_selesai = $_POST['tanggal_selesai'];
$no_laporan = $_POST['no_laporan'];
$no_deposit = $_POST['no_deposit'];
$qty_deposit_dikirim = $_POST['qty_deposit_dikirim'];

$table = mysqli_query($koneksi, "SELECT * FROM riwayat_deposit a INNER JOIN riwayat_penjualan b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON c.kode_baja=b.kode_baja WHERE a.no_transaksi = '$no_laporan' ");
$data_hutang = mysqli_fetch_array($table);

$kode_baja = $data_hutang['kode_baja'];
$qty_deposit = $data_hutang['qty'];
$referensi = $data_hutang['referensi'];
$riwayat_qty_deposit_dikirim = $data_hutang['qty_deposit_dikirim'];

$total = $riwayat_qty_deposit_dikirim + $qty_deposit_dikirim;

if($total > $qty_deposit){
	echo "<script> alert('Kirimnya Kebanyakan Gaes!'); window.location='../view/VRiwayatDeposit1';</script>";exit;
}
else if($total < $qty_deposit){
$status_deposit = 'Diamabil Sebagian';

if ($referensi == 'TK') {
	if ($kode_baja == 'L03K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total' ,status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
}

//REFERENSI GUDANG
elseif ($referensi == 'GD') {
	if ($kode_baja == 'L03K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
}
}

else if($total == $qty_deposit){
$status_deposit = 'Sudah Diambil';

if ($referensi == 'TK') {
	if ($kode_baja == 'L03K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total' ,status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['toko'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['toko'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['toko'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Toko','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
}

//REFERENSI GUDANG
elseif ($referensi == 'GD') {
	if ($kode_baja == 'L03K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L03K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'L12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B05K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K01') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
		$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Masuk','$qty_deposit')");
		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K11') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;
		//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - $qty_deposit;

		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");

		//Update Status Deposit
		$query6 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
	elseif ($kode_baja == 'B12K10') {
		//inventory
		//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - $qty_deposit;

		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_selesai','$no_laporan','Gudang','Keluar','$qty_deposit')");
		//Update Status Deposit
		$query4 = mysqli_query($koneksi,"UPDATE riwayat_deposit SET tanggal_ambil = '$tanggal_selesai', qty_deposit_dikirim = '$total',status_deposit = '$status_deposit' WHERE no_deposit = '$no_deposit' ");
		echo "<script> window.location='../view/VRiwayatDeposit1';</script>";exit;
	}
}


}


