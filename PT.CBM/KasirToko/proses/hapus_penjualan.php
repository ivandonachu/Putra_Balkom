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

$no_laporan=$_POST['no_laporan'];
$tanggal_awal=$_POST['tanggal1'];
$tanggal_akhir=$_POST['tanggal2'];



$result = mysqli_query($koneksi, "SELECT * FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan' ");
$data_transaksi = mysqli_fetch_array($result);
$referensi = $data_transaksi['referensi'];
$kode_baja = $data_transaksi['kode_baja'];
$pembayaran = $data_transaksi['pembayaran'];
$qty = $data_transaksi['qty'];
$jumlah = $data_transaksi['jumlah'];
$nama = $data_transaksi['nama'];
$penyaluran = $data_transaksi['penyaluran'];
//Hapus Peminjaman
$result2 = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman WHERE no_transaksi = '$no_laporan' ");

if(mysqli_num_rows($result2) === 1 ){

	if ($referensi == 'TK') {
		if ($kode_baja == 'L03K11') {
	 		//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = 'L03K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		elseif ($kode_baja == 'L03K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'L12K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = 'L12K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'L12K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B05K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = 'B05K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B05K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B12K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = 'B12K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B12K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

	}

	elseif ($referensi == 'GD') {
			if ($kode_baja == 'L03K11') {
	 		//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L03K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'L03K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		elseif ($kode_baja == 'L03K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'L12K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'L12K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'L12K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'L12K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B05K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B05K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'B05K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B05K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B12K11') {
			//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = 'B12K01' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'B12K01' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		elseif ($kode_baja == 'B12K10') {
				//pinjam
			$akses_inventory_pinjam = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_pinjam = mysqli_fetch_array($akses_inventory_pinjam);
			$jumlah_baja_pinjam = $data_inventory_pinjam['dipinjam'];
			$jumlah_baja_pinjam_new = $jumlah_baja_pinjam - $qty;

			//BAJA + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;


				$query1 = mysqli_query($koneksi,"UPDATE inventory SET dipinjam = '$jumlah_baja_pinjam_new' WHERE kode_baja = '$kode_baja' ");
				$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}

		
		}

}

//HAPUS PENJUALAN
if ($referensi == 'TK') {
	//jenis pembayaran
	//Cash
	if ($pembayaran == 'Cash') {
		
		if ($kode_baja == "L03K01") {
			if ($penyaluran == 'Pangkalan') {
			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

			//aktivitas inventory
		    //baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
				$jumlah_baja_b = $data_inventory_b['gudang'];
				$jumlah_baja_b_new = $jumlah_baja_b + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
				$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['toko'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['toko'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($kode_baja == "L03K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L03K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	//Briva
	else if ($pembayaran == 'Briva') {
			//hapus rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			//aktivitas inventory
		    //baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");

			//hapus penjualan
		$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


		echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	}
	//Briva
	else if ($pembayaran == 'Mocash') {
			//hapus rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			//aktivitas inventory
		    //baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");


			//hapus penjualan
		$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


		echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	}
	//Transfer
	else if ($pembayaran == 'Transfer') {

		if ($kode_baja == "L03K01") {
			if ($penyaluran == 'Pangkalan') {
				//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['toko'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['toko'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($kode_baja == "L03K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L03K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja =="L12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja =="L12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	//Bon
	else if ($pembayaran == 'Bon') {
		if ($kode_baja == "L03K01") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L03K11") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L03K10") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L12K01") {
				//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L12K11") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja =="L12K10") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K01") {
				//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K11") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K10") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K01") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['toko'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

			$query4 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K11") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['toko'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K10") {
		//hapus inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['toko'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
			$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
	}
	//Deposit
	else if ($pembayaran == 'Deposit') {
		if ($kode_baja == "L03K01") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L03K11") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L03K10") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L12K01") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L12K11") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "L12K10") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K01") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K11") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B05K10") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K01") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K11") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
		else if ($kode_baja == "B12K10") {
		//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
	}
}
else if ($referensi == 'GD') {
		//jenis pembayaran
	//Cash
	if ($pembayaran == 'Cash') {
		
		if ($kode_baja == "L03K01") {
			if ($penyaluran == 'Pangkalan') {
			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

			//aktivitas inventory
		    //baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
				$jumlah_baja_b = $data_inventory_b['gudang'];
				$jumlah_baja_b_new = $jumlah_baja_b + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

				$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");

			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($kode_baja == "L03K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L03K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "L12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B05K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K01") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");


			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K11") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
			$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
			$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
			$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
		else if ($kode_baja == "B12K10") {
			//hapus inventory
			//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
			$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang - $jumlah;

			$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


			//hapus penjualan
			$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			
			echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}
	//Briva
	else if ($pembayaran == 'Briva') {
			//hapus rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			//aktivitas inventory
		    //baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		

			//hapus penjualan
		$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


		echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	}
	else if ($pembayaran == 'Mocash') {
			//hapus rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;

		$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			//aktivitas inventory
		    //baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b + $qty;

		$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
		
		$query44 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
		

			//hapus penjualan
		$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


		echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
	}
	//Transfer
	else if ($pembayaran == 'Transfer') {

		if ($kode_baja == "L03K01") {
			if ($penyaluran == 'Pangkalan') {
				//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else{
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-115'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-115' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;}
			}
			else if ($kode_baja == "L03K11") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "L03K10") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "L12K01") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "L12K11") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "L12K10") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B05K01") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B05K11") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B05K10") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B12K01") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");


			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B12K11") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "B12K10") {
			//hapus inventory
			//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
			//baja kosong
				$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");		

			//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");


			//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
	//Bon
		else if ($pembayaran == 'Bon') {
			if ($kode_baja == "L03K01") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");

				//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

			//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L03K11") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L03K01' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L03K10") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");
				//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L12K01") {
				//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");
				//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L12K11") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'L12K01' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
			}
			else if ($kode_baja == "L12K10") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");
//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B05K01") {
				//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
			}
			else if ($kode_baja == "B05K11") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B05K01' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
			}
			else if ($kode_baja == "B05K10") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K01") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja kosong
				$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
				$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
				$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
				$jumlah_baja_ksg_new = $jumlah_baja_ksg - $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K11' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

				$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");
//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K11") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;
		//baja + isi
				$akses_inventory_isi2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
				$data_inventory_isi2 = mysqli_fetch_array($akses_inventory_isi2);
				$jumlah_baja_isi2 = $data_inventory_isi2['gudang'];
				$jumlah_baja_isi_new2 = $jumlah_baja_isi2 + $qty;

				$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new2' WHERE kode_baja = 'B12K01' ");
				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");

				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K10") {
		//hapus inventory
		//baja isi
				$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
				$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
				$jumlah_baja_isi = $data_inventory_isi['gudang'];
				$jumlah_baja_isi_new = $jumlah_baja_isi + $qty;

				$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");

		//hapus piutang penjualan
				$query6 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");
//total bon 
			//akses databon 
			$sql_akses_bon = mysqli_query($koneksi, "SELECT * FROM piutang_penjualan WHERE sub_penyalur = '$nama'");
			$data_bon = mysqli_fetch_array($sql_akses_bon);
			$no_piutang = $data_bon['no_piutang'];

			$total_qty_baja = $data_bon['total_qty_baja'];
			$total_piutang = $data_bon['total_piutang'];
			
			$total_qty_baja_baru = $total_qty_baja - $qty;
			$total_piutang_baru = $total_piutang - $jumlah;

			if($total_piutang_baru == 0 || $total_piutang_baru < 0){
				mysqli_query($koneksi,"DELETE FROM piutang_penjualan WHERE no_piutang = '$no_piutang'");
			}
			else{

	
			mysqli_query($koneksi,"UPDATE piutang_penjualan SET total_qty_baja = '$total_qty_baja_baru', total_piutang = '$total_piutang_baru' WHERE no_piutang = '$no_piutang' ");

			}
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
		}
	//Deposit
		else if ($pembayaran == 'Deposit') {
			if ($kode_baja == "L03K01") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
			else if ($kode_baja == "L03K11") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L03K10") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L12K01") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L12K11") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "L12K10") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B05K01") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B05K11") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B05K10") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K01") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K11") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
			else if ($kode_baja == "B12K10") {
		//hapus rekening
				$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
				$data_rekening = mysqli_fetch_array($akses_rekening);
				$jumlah_uang = $data_rekening['jumlah'];
				$jumlah_uang_new = $jumlah_uang - $jumlah;

				$query3 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");


		//hapus penjualan
				$query4 = mysqli_query($koneksi,"DELETE FROM riwayat_penjualan WHERE no_transaksi = '$no_laporan'");


				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

			}
		}
	}

