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

$tanggal = $_POST['tanggal'];
$qty = $_POST['qty'];
$lokasi_awal = $_POST['lokasi_awal'];
$lokasi_tujuan = $_POST['lokasi_tujuan'];
$nama_baja = $_POST['nama_baja'];
$keterangan = $_POST['keterangan'];

		$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
		$data_baja = mysqli_fetch_array($result);
		$kode_baja = $data_baja['kode_baja'];

if ($lokasi_awal == 'Toko') {
	if ($lokasi_tujuan =='Gudang') {
		//riwayat pengeluran
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','TK','$kode_baja','$qty','$lokasi_awal','$lokasi_tujuan','$keterangan')");

		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 + $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'L03K01' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'L03K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'L03K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}

		elseif ($kode_baja == 'L12K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 + $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'L12K01' ");
			

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'L12K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'L12K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B05K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 + $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'B05K01' ");
			

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'B05K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			//baja kendaraan
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken + $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B05K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B12K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 - $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 + $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'B12K01' ");
	

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'B12K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B12K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko - $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 + $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		
	}
	else{echo "<script> alert('Lokasi Awal dan Lokasi Tujuan tidak bisa sama'); window.location='../view/VPerpindahanBaja1';</script>";exit;}

}

if ($lokasi_awal == 'Gudang') {
	if ($lokasi_tujuan =='Toko') {
		//riwayat pengeluran
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_perpindahan_baja VALUES ('','$tanggal','TK','$kode_baja','$qty','$lokasi_awal','$lokasi_tujuan','$keterangan')");

		
		if ($kode_baja == 'L03K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 - $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'L03K01' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'L03K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'L03K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}

		elseif ($kode_baja == 'L12K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 - $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'L12K01' ");
			

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'L12K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'L12K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B05K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 - $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'B05K01' ");
			

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'B05K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			//baja kendaraan
			$akses_inventory_ken = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_ken = mysqli_fetch_array($akses_inventory_ken);
			$jumlah_baja_ken = $data_inventory_ken['gudang'];
			$jumlah_baja_ken_new = $jumlah_baja_ken - $qty;

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ken_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B05K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B12K11') {
			//aktivitas inventory
			//baja toko 1
			$akses_inventory_toko1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko1 = mysqli_fetch_array($akses_inventory_toko1);
			$jumlah_baja_isi1 = $data_inventory_toko1['toko'];
			$jumlah_baja_toko1 = $jumlah_baja_isi1 + $qty;
			//baja toko 2
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['toko'];
			$jumlah_baja_toko2 = $jumlah_baja_b + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;			
			// baja gudang 2
			$akses_inventory_gd2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_gd2 = mysqli_fetch_array($akses_inventory_gd2);
			$jumlah_baja_gd2 = $data_inventory_gd2['gudang'];
			$jumlah_baja_gd2_new = $jumlah_baja_gd2 - $qty;		

			$query1 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko2' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko1' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd2_new' WHERE kode_baja = 'B12K01' ");
	

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
			
		}
		elseif ($kode_baja == 'B12K10') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		elseif ($kode_baja == 'B12K00') {
			//aktivitas inventory
			//baja Toko
			$akses_inventory_toko = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_toko = mysqli_fetch_array($akses_inventory_toko);
			$jumlah_baja_toko = $data_inventory_toko['toko'];
			$jumlah_baja_toko_new = $jumlah_baja_toko + $qty;
			// baja gudang 1
			$akses_inventory_gd1 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gd1 = mysqli_fetch_array($akses_inventory_gd1);
			$jumlah_baja_gd1 = $data_inventory_gd1['gudang'];
			$jumlah_baja_gd1_new = $jumlah_baja_gd1 - $qty;	

			$query1= mysqli_query($koneksi,"UPDATE inventory SET toko = '$jumlah_baja_toko_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gd1_new' WHERE kode_baja = '$kode_baja' ");

			if ($query != "") {
				echo "<script> window.location='../view/VPerpindahanBaja1';</script>";exit;
			}
		}
		
	}
	else{echo "<script> alert('Lokasi Awal dan Lokasi Tujuan tidak bisa sama'); window.location='../view/VPerpindahanBaja1';</script>";exit;}

}

