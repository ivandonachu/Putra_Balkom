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

		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
			if ($penyaluran == 'Pangkalan') {
				//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			//aktivitas inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
			
			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
				}
			}
			else{
		//aktivitas inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L03K11';

		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}			
		else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B05K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B05K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		// isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}

		else if ($nama_baja == "Pendapatan Lain-lain Diluar Usaha") {
			$kode_akun = '5-610';
			$kode_baja = 'L03K01';
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}

	}

	//Briva
	if ($pembayaran=="Briva") {
		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];


			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','$nama','Keluar','$qty')");
			//aktivitas inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query4 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}


		}
		else{
			echo "<script> alert('Transaksi tidak bisa menggunakan Briva !');
			window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

	//Mocash
	if ($pembayaran=="Mocash") {
		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];


			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','$nama','Keluar','$qty')");
			//aktivitas inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query4 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}


		}
		else{
			echo "<script> alert('Transaksi tidak bisa menggunakan Briva !');
			window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
		}
	}

	//Transfer
	if ($pembayaran=="Transfer") {
		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];


			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','$nama','Keluar','$qty')");
			//aktivitas inventory
		//baja isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query4 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
}
			
		else if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L03K11';

		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K11' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}			
		else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B05K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B05K11';
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
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-114'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-114' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','4','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-116'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-116' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','6','Masuk','$jumlah')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}

		else if ($nama_baja == "Pendapatan Lain-lain Diluar Usaha") {
			$kode_akun = '5-610';
			$kode_baja = 'L03K01';
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
	}
	//Bon
	if ($pembayaran=="Bon") {
		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L03K11';

		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}			
		else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B05K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B05K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B05K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B05K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B12K01';
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
		//baja kosong
			$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
			$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
			$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
			$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;
		//baja + isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K11' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
			$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'B12K10' ");
			$query5 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Masuk','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas inventory
		//baja + isi
			$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = '$kode_baja'");
			$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
			$jumlah_baja_isi = $data_inventory_isi['gudang'];
			$jumlah_baja_isi_new = $jumlah_baja_isi - $qty;
		//isi
			$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
			$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
			$jumlah_baja_b = $data_inventory_b['gudang'];
			$jumlah_baja_b_new = $jumlah_baja_b - $qty;

			$query11 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'B12K01' ");
			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
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

			$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = '$kode_baja' ");
			$query3 = mysqli_query($koneksi,"INSERT INTO aktivitas_inventory VALUES ('','$tanggal','$no_transaksi','Gudang','Keluar','$qty')");
		//aktivitas piutang penjualan
			$status_piutang = 'Belum di Bayar'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO piutang_dagang VALUES ('',00-00-0000,'$no_transaksi',0,'$status_piutang')");


			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
	}
	//Doposit
	if ($pembayaran=="Deposit") {
		if ($nama_baja == "Elpiji 3 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L03K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L03K11';

		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 3 Kg Baja Kosong") {
			$kode_akun = '4-130';
			$kode_baja = 'L03K10';

		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");
			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'L12K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}			
		else if ($nama_baja == "Elpiji 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'L12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Elpiji 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
			$kode_baja = 'L12K10';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B05K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B05K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 5,5 Kg Baja Kosong") {
			$kode_akun = '4-130';
			$kode_baja = 'B05K10';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Isi") {
			$kode_akun = '4-110';
			$kode_baja = 'B12K01';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja + Isi") {
			$kode_akun = '4-120';
			$kode_baja = 'B12K11';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");

			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
		else if ($nama_baja == "Bright Gas 12 Kg Baja Kosong") {
			$kode_akun = '4-130';
			$kode_baja = 'B12K10';
		//riwayat penjualan
			$query1 = mysqli_query($koneksi,"INSERT INTO riwayat_penjualan VALUES ('','$id','$tanggal','$referensi','$kode_akun','$kode_baja','$penyaluran',
				'$nama','$pembayaran','$qty','$harga','$jumlah','$keterangan','$file')");
			$akses_riwayat_penjualan = mysqli_query($koneksi, "SELECT MAX(no_transaksi) FROM riwayat_penjualan");
			$akses_data_penjualan = mysqli_fetch_array($akses_riwayat_penjualan);
			$no_transaksi = $akses_data_penjualan['MAX(no_transaksi)'];
		//aktivitas rekening
			$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
			$data_rekening = mysqli_fetch_array($akses_rekening);
			$jumlah_uang = $data_rekening['jumlah'];
			$jumlah_uang_new = $jumlah_uang + $jumlah;

			$query6 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");
			$query7 = mysqli_query($koneksi,"INSERT INTO aktivitas_rekening VALUES ('','$tanggal','$no_transaksi','1','Masuk','$jumlah')");
		//Deposit
			$status_deposit = 'Belum Diambil'; 
			$query6 = mysqli_query($koneksi,"INSERT INTO riwayat_deposit VALUES ('',00-00-0000,'$no_transaksi','$status_deposit')");
			if ($query1!= "") {
				echo "<script> window.location='../view/VPenjualan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
		}
	}

