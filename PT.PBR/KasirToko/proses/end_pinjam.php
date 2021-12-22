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

$no_laporan = $_POST['no_laporan'];
$no_pinjam = $_POST['no_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];
$qty_kembali = $_POST['qty_kembali'];
$nama_baja_kembali = $_POST['nama_baja_kembali'];
$table = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman a INNER JOIN riwayat_penjualan b ON a.no_transaksi=b.no_transaksi INNER JOIN baja c ON c.kode_baja=b.kode_baja WHERE a.no_transaksi = '$no_laporan' ");
$data_pinjam = mysqli_fetch_array($table);
$qty_pinjam = $data_pinjam['qty'];
$qty_kembali_2 = $data_pinjam['qty_kembali'];
$kode_baja = $data_pinjam['kode_baja'];
$referensi = $data_pinjam['referensi'];
$qty_kembalix = $qty_kembali_2 + $qty_kembali;


if ($qty_kembali + $qty_kembali_2 > $qty_pinjam ) {
	echo "<script> alert('Kembalinya Kebanyakan Gaes!'); window.location='../view/VRiwayatPeminjaman1';</script>";exit;

}

elseif ($qty_kembali + $qty_kembali_2 < $qty_pinjam) {

	if ($kode_baja == 'L03K11') {
			if ($nama_baja_kembali == 'Elpiji 3 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 3 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}			
		}

		elseif($kode_baja == 'L03K10'){
			if ($nama_baja_kembali == 'Elpiji 3 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 3 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}			
		}
		elseif($kode_baja == 'L12K11'){
			if ($nama_baja_kembali == 'Elpiji 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'L12K10'){
			if ($nama_baja_kembali == 'Elpiji 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B05K11'){
			if ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B05K10'){
			if ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B12K11'){
			if ($nama_baja_kembali == 'Bright Gas 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B12K10'){
			if ($nama_baja_kembali == 'Bright Gas 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}


}



//jumlah sama pas
elseif ($qty_kembali + $qty_kembali_2 == $qty_pinjam) {
	$status_pinjam = 'Sudah Dikembalikan';
	
	if ($kode_baja == 'L03K11') {
			if ($nama_baja_kembali == 'Elpiji 3 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 3 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}			
		}

		elseif($kode_baja == 'L03K10'){
			if ($nama_baja_kembali == 'Elpiji 3 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 3 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}			
		}
		elseif($kode_baja == 'L12K11'){
			if ($nama_baja_kembali == 'Elpiji 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'L12K10'){
			if ($nama_baja_kembali == 'Elpiji 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Elpiji 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B05K11'){
			if ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B05K10'){
			if ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 5,5 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B12K11'){
			if ($nama_baja_kembali == 'Bright Gas 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K01' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K11' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}
		elseif($kode_baja == 'B12K10'){
			if ($nama_baja_kembali == 'Bright Gas 12 Kg Baja + Isi') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;
				

				$query91 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K11' ");
				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K01' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix' WHERE no_pinjam 
					= '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
			elseif ($nama_baja_kembali == 'Bright Gas 12 Kg Baja Kosong') {
				//aktivitas inventory
				//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty_kembali;
				//pinjam
				$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
				$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
				$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty_kembali;

				
				
				$query9 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K10' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
				$query2 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal_kembali','$no_laporan','Gudang','Masuk','$qty_kembali')");

				//riwayatpinjam
				$query3 = mysqli_query($koneksi,"UPDATE riwayat_peminjaman SET tanggal_bayar = '$tanggal_kembali' , qty_kembali = '$qty_kembalix', 
				status_pinjam ='$status_pinjam' WHERE no_pinjam = '$no_pinjam' ");

				echo "<script> window.location='../view/VRiwayatPeminjaman1';</script>";exit;
			}
		}


}

