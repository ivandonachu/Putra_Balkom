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
$tanggal = $_POST['tanggal'];
$qty = $_POST['qty'];
$nama_baja = $_POST['nama_baja'];
$nama_pangkalan = $_POST['nama'];
$keterangan = $_POST['keterangan'];


		$result = mysqli_query($koneksi, "SELECT * FROM baja WHERE nama_baja = '$nama_baja' ");
		$data_baja = mysqli_fetch_array($result);
		$kode_baja = $data_baja['kode_baja'];

		//riwayat konfirmasi retur
		$query = mysqli_query($koneksi,"INSERT INTO riwayat_retur_pangkalan VALUES ('','$tanggal','$nama_pangkalan','$kode_baja','$qty','$keterangan')");

		if ($nama_baja == 'Elpiji 3 Kg Isi') {
			
			//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_gudang = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gudang = mysqli_fetch_array($akses_inventory_gudang);
			$jumlah_baja_gudang = $data_inventory_gudang['gudang'];
			$jumlah_baja_gudang_new = $jumlah_baja_gudang - $qty;
			//baja Terdeteksi2
			$akses_inventory_gudang2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_gudang2 = mysqli_fetch_array($akses_inventory_gudang2);
			$jumlah_baja_gudang2 = $data_inventory_gudang2['gudang'];
			$jumlah_baja_gudang_new2 = $jumlah_baja_gudang2 - $qty;
			//baja retur
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = 'L03K11' ");

			if ($query != "") {
					echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				}
		}
		elseif ($nama_baja == 'Elpiji 12 Kg Isi') {
					//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_gudang = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gudang = mysqli_fetch_array($akses_inventory_gudang);
			$jumlah_baja_gudang = $data_inventory_gudang['gudang'];
			$jumlah_baja_gudang_new = $jumlah_baja_gudang - $qty;
			//baja Terdeteksi2
			$akses_inventory_gudang2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_gudang2 = mysqli_fetch_array($akses_inventory_gudang2);
			$jumlah_baja_gudang2 = $data_inventory_gudang2['gudang'];
			$jumlah_baja_gudang_new2 = $jumlah_baja_gudang2 - $qty;
			//baja retur
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = 'L12K11' ");

			if ($query != "") {
					echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				}
		}
		elseif ($nama_baja == 'Bright Gas 5,5 Kg Isi') {
					//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_gudang = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gudang = mysqli_fetch_array($akses_inventory_gudang);
			$jumlah_baja_gudang = $data_inventory_gudang['gudang'];
			$jumlah_baja_gudang_new = $jumlah_baja_gudang - $qty;
			//baja Terdeteksi2
			$akses_inventory_gudang2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_gudang2 = mysqli_fetch_array($akses_inventory_gudang2);
			$jumlah_baja_gudang2 = $data_inventory_gudang2['gudang'];
			$jumlah_baja_gudang_new2 = $jumlah_baja_gudang2 - $qty;
			//baja retur
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = 'B05K11' ");

			if ($query != "") {
					echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				}
		}
		elseif ($nama_baja == 'Bright Gas 12 Kg Isi') {
					//aktivitas inventory
			//baja Terdeteksi
			$akses_inventory_gudang = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_gudang = mysqli_fetch_array($akses_inventory_gudang);
			$jumlah_baja_gudang = $data_inventory_gudang['gudang'];
			$jumlah_baja_gudang_new = $jumlah_baja_gudang - $qty;
			//baja Terdeteksi2
			$akses_inventory_gudang2 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_gudang2 = mysqli_fetch_array($akses_inventory_gudang2);
			$jumlah_baja_gudang2 = $data_inventory_gudang2['gudang'];
			$jumlah_baja_gudang_new2 = $jumlah_baja_gudang2 - $qty;
			//baja retur
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;



			$query1= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = '$kode_baja' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
			$query3= mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_gudang_new' WHERE kode_baja = 'B12K11' ");

			if ($query != "") {
					echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				}
		}