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

$tanggal_awal = $_POST['tanggal1'];
$tanggal_akhir = $_POST['tanggal2'];
$no_pengeluaran = $_POST['no_pengeluaran'];
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

		move_uploaded_file($tmp_name, '../file_toko/' . $nama_file_baru   );

		return $nama_file_baru; 

	}

	$file = upload();
	if (!$file) {
		return false;
	}

}

if ($akun == 'Transport / Perjalanan Dinas') {
    $kode_akun = '5-530';

}
elseif ($akun == 'Biaya Usaha Lainnya') {
    $kode_akun = '5-590';

}
elseif ($akun == 'Biaya Perbaikan Kendaraan') {
    $kode_akun = '5-595';

}
elseif ($akun == 'Alat Tulis Kantor') {
    $kode_akun = '5-520';

}
elseif ($akun == 'Listrik & Telepon') {
    $kode_akun = '5-550';

}
elseif ($akun == 'Biaya Kantor') {
    $kode_akun = '5-540';

}
elseif ($akun == 'Biaya Konsumsi') {
    $kode_akun = '5-560';

}
elseif ($akun == 'Prive') {
    $kode_akun = '5-570';

}
elseif ($akun == 'Biaya Penjualan & Pemasaran') {
    $kode_akun = '5-580';

}
elseif ($akun == 'Kembalikan Saldo Mocash') {
    $kode_akun = '1-114';

}
elseif ($akun == 'Kembalikan Saldo Brankas') {
    $kode_akun = '1-113';

}
elseif ($akun == 'Setor Pendapatan') {
    $kode_akun = '1-111';

}
elseif ($akun == 'Pengeluaran Lainnya') {
    $kode_akun = '5-596';

}



	if ($file == '') {
		$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengeluaran SET tanggal = '$tanggal',referensi = '$referensi' , kode_akun = '$kode_akun' , keterangan = '$keterangan' ,jumlah_pengeluaran = '$jumlah'  WHERE no_pengeluaran = 
		'$no_pengeluaran'");
	}
	else{
		$query3 = mysqli_query($koneksi,"UPDATE riwayat_pengeluaran SET tanggal = '$tanggal',referensi = '$referensi' , kode_akun = '$kode_akun'  , keterangan = '$keterangan' ,jumlah_pengeluaran = '$jumlah' ,  file_bukti = '$file' WHERE no_pengeluaran = 
		'$no_pengeluaran'");
	}

		echo "<script>alert('Data Berhasil Di Edit :)'); window.location='../view/VPengeluaran2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;



  ?>