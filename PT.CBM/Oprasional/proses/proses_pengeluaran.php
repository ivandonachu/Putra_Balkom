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
if ($jabatan_valid == 'Kepala Oprasional') {

}

else{  header("Location: logout.php");
exit;
}

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$referensi = $_POST['referensi'];
$tanggal = $_POST['tanggal'];
$akun = $_POST['akun'];
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

		move_uploaded_file($tmp_name, '../../../PT.PBR/KasirToko/file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

	if ($akun == 'Prive') {
		$kode_akun = '3-500';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
			echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Transport / Perjalanan Dinas') {
		$kode_akun = '5-530';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Usaha Lainnya') {
		$kode_akun = '5-590';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Perbaikan Kendaraan') {
		$kode_akun = '5-595';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Alat Tulis Kantor') {
		$kode_akun = '5-520';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Listrik & Telepon') {
		$kode_akun = '5-550';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Kantor') {
		$kode_akun = '5-540';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Penyusutan') {
		$kode_akun = '5-560';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Sewa') {
		$kode_akun = '5-570';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");
		//aktivitas rekening
		$akses_rekening = mysqli_query($koneksipbr, "SELECT * FROM rekening WHERE kode_akun = '1-111'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang - $jumlah;
		$query1 = mysqli_query($koneksipbr,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-111' ");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}
	elseif ($akun == 'Biaya Penjualan & Pemasaran') {
		$kode_akun = '5-580';
		//riwayat pengeluran
		$query = mysqli_query($koneksipbr,"INSERT INTO riwayat_pengeluaran VALUES ('','$tanggal','$referensi','$kode_akun','$keterangan','$jumlah','$file')");

		if ($query != "") {
				echo "<script> window.location='../view/VPengeluaranPBR?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
			}
	}

	