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

$tanggal = $_POST['tanggal'];
$qty = $_POST['qty'];
$nama_baja = $_POST['nama_baja'];
$keterangan = $_POST['keterangan'];

		$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
		$data_baja = mysqli_fetch_array($result);
		$kode_baja = $data_baja['kode_baja'];

		//riwayat konfirmasi retur
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_konfirmasi_retur VALUES ('','$tanggal','GD','$kode_baja','$qty','$keterangan')");



		if ($nama_baja == 'Elpiji 3 Kg Baja + Isi') {
			
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja Terdeteksi2
			$akses_inventory_toko2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_toko2 = mysqli_fetch_array($akses_inventory_toko2);
			$jumlah_baja_toko2 = $data_inventory_toko2['gudang'];
			$jumlah_baja_toko_new2 = $jumlah_baja_toko2 - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'L03K00' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = 'L03K01' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Elpiji 3 Kg Baja Kosong') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'L03K00' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Elpiji 12 Kg Baja + Isi') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja Terdeteksi2
			$akses_inventory_toko2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_toko2 = mysqli_fetch_array($akses_inventory_toko2);
			$jumlah_baja_toko2 = $data_inventory_toko2['gudang'];
			$jumlah_baja_toko_new2 = $jumlah_baja_toko2 - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'L12K00' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = 'L12K01' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Elpiji 12 Kg Baja Kosong') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'L12K00' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Bright Gas 5,5 Kg Baja + Isi') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja Terdeteksi2
			$akses_inventory_toko2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_toko2 = mysqli_fetch_array($akses_inventory_toko2);
			$jumlah_baja_toko2 = $data_inventory_toko2['gudang'];
			$jumlah_baja_toko_new2 = $jumlah_baja_toko2 - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'B05K00' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = 'B05K01' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Bright Gas 5,5 Kg Baja Kosong') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'B05K00' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Bright Gas 12 Kg Baja + Isi') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja Terdeteksi2
			$akses_inventory_toko2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_toko2 = mysqli_fetch_array($akses_inventory_toko2);
			$jumlah_baja_toko2 = $data_inventory_toko2['gudang'];
			$jumlah_baja_toko_new2 = $jumlah_baja_toko2 - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'B12K00' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = 'B12K01' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
		elseif ($nama_baja =='Bright Gas 12 Kg Baja Kosong') {
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['gudang'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja retur
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = 'B12K00' ");

			if ($query != "") {
					echo "<script> window.location='../view/VKonfirmasiRetur';</script>";exit;
				}
		}
