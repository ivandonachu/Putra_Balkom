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
$no_keberangkatan = $_POST['no_keberangkatan'];
$uang_jalan = $_POST['uang_jalan'];
$L03K11 = $_POST['L03K11'];
$L12K11 = $_POST['L12K11'];
$B05K11	= $_POST['B05K11'];
$B12K11 = $_POST['B12K11'];
$L03K00 = $_POST['L03K00'];
$L12K00 = $_POST['L12K00'];
$B05K00 = $_POST['B05K00'];
$B12K00 = $_POST['B12K00'];
$status = $_POST['status'];


if ($status == 'Hanya Kamvas') {

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_keberangkatan WHERE no_keberangkatan = '$no_keberangkatan'");

		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $uang_jalan;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");


		echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

	}


if ($status == 'Kamvas + Pengisian') {
		if ($L03K11 == 0) {
			     //LPG12KG
            //baja isi
        $akses_inventory_isi12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
        $data_inventory_isi12 = mysqli_fetch_array($akses_inventory_isi12);
        $jumlah_baja_isi12 = $data_inventory_isi12['gudang'];
        $jumlah_baja_isi_new12 = $jumlah_baja_isi12 - ($L12K11 + $L12K00);
            //baja + isi
        $akses_inventory_b12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
        $data_inventory_b12 = mysqli_fetch_array($akses_inventory_b12);
        $jumlah_baja_b12 = $data_inventory_b12['gudang'];
        $jumlah_baja_b_new12 = $jumlah_baja_b12 - ($L12K11 + $L12K00);
        //retur
        $akses_inventory_b12rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
        $data_inventory_b12rt = mysqli_fetch_array($akses_inventory_b12rt);
        $jumlah_baja_b12rt = $data_inventory_b12rt['gudang'];
        $jumlah_baja_b_new12rt = $jumlah_baja_b12rt + $L12K00;
        //baja kosong
        $akses_inventory_ksg12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
        $data_inventory_ksg12 = mysqli_fetch_array($akses_inventory_ksg12);
        $jumlah_baja_ksg12 = $data_inventory_ksg12['gudang'];
        $jumlah_baja_ksg_new12 = $jumlah_baja_ksg12 + $L12K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new12' WHERE kode_baja = 'L12K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new12' WHERE kode_baja = 'L12K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new12' WHERE kode_baja = 'L12K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new12rt' WHERE kode_baja = 'L12K00' ");

            //BG55KG
            //baja isi
        $akses_inventory_isi5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
        $data_inventory_isi5 = mysqli_fetch_array($akses_inventory_isi5);
        $jumlah_baja_isi5 = $data_inventory_isi5['gudang'];
        $jumlah_baja_isi_new5 = $jumlah_baja_isi5 - ($B05K11 + $B05K00);
            //baja + isi
        $akses_inventory_b5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
        $data_inventory_b5 = mysqli_fetch_array($akses_inventory_b5);
        $jumlah_baja_b5 = $data_inventory_b5['gudang'];
        $jumlah_baja_b_new5 = $jumlah_baja_b5 - ($B05K11 + $B05K00);
            //baja RETUR
        $akses_inventory_b5rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
        $data_inventory_b5rt = mysqli_fetch_array($akses_inventory_b5rt);
        $jumlah_baja_b5rt = $data_inventory_b5rt['gudang'];
        $jumlah_baja_b_new5rt = $jumlah_baja_b5rt + $B05K00;
        //baja kosong
        $akses_inventory_ksg5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
        $data_inventory_ksg5 = mysqli_fetch_array($akses_inventory_ksg5);
        $jumlah_baja_ksg5 = $data_inventory_ksg5['gudang'];
        $jumlah_baja_ksg_new5 = $jumlah_baja_ksg5 + $B05K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new5' WHERE kode_baja = 'B05K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new5' WHERE kode_baja = 'B05K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new5' WHERE kode_baja = 'B05K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new5rt' WHERE kode_baja = 'B05K00' ");

            //BG12KG
            //baja isi
        $akses_inventory_isib12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
        $data_inventory_isib12 = mysqli_fetch_array($akses_inventory_isib12);
        $jumlah_baja_isib12 = $data_inventory_isib12['gudang'];
        $jumlah_baja_isi_newb12 = $jumlah_baja_isib12 - ($B12K11 + $B12K00);
            //baja + isi
        $akses_inventory_bb12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
        $data_inventory_bb12 = mysqli_fetch_array($akses_inventory_bb12);
        $jumlah_baja_bb12 = $data_inventory_bb12['gudang'];
        $jumlah_baja_b_newb12 = $jumlah_baja_bb12 - ($B12K11 + $B12K00);
        //RETUR
        $akses_inventory_bb12rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
        $data_inventory_bb12rt = mysqli_fetch_array($akses_inventory_bb12rt);
        $jumlah_baja_bb12rt = $data_inventory_bb12rt['gudang'];
        $jumlah_baja_b_newb12rt = $jumlah_baja_bb12rt + $B12K00;
        //baja kosong
        $akses_inventory_ksgb12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
        $data_inventory_ksgb12 = mysqli_fetch_array($akses_inventory_ksgb12);
        $jumlah_baja_ksgb12 = $data_inventory_ksgb12['gudang'];
        $jumlah_baja_ksg_newb12 = $jumlah_baja_ksgb12 + $B12K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_newb12' WHERE kode_baja = 'B12K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_newb12' WHERE kode_baja = 'B12K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_newb12' WHERE kode_baja = 'B12K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_newb12rt' WHERE kode_baja = 'B12K00' ");
        //Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_keberangkatan WHERE no_keberangkatan = '$no_keberangkatan'");

		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $uang_jalan;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");


		echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;


			}	
		else {
		$qty = $L03K11;
        $qty2 = $L03K00;
			//3KG
			//baja isi
		$akses_inventory_isi = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K01'");
		$data_inventory_isi = mysqli_fetch_array($akses_inventory_isi);
		$jumlah_baja_isi = $data_inventory_isi['gudang'];
		$jumlah_baja_isi_new = $jumlah_baja_isi - ($qty + $qty2);
			//baja + isi
		$akses_inventory_b = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K11'");
		$data_inventory_b = mysqli_fetch_array($akses_inventory_b);
		$jumlah_baja_b = $data_inventory_b['gudang'];
		$jumlah_baja_b_new = $jumlah_baja_b - ($qty + $qty2);
        //RETUR
        $akses_inventory_rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K00'");
        $data_inventory_rt = mysqli_fetch_array($akses_inventory_rt);
        $jumlah_baja_rt = $data_inventory_rt['gudang'];
        $jumlah_baja_rt_new = $jumlah_baja_rt + $qty2;
		//baja kosong
		$akses_inventory_ksg = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L03K10'");
		$data_inventory_ksg = mysqli_fetch_array($akses_inventory_ksg);
		$jumlah_baja_ksg = $data_inventory_ksg['gudang'];
		$jumlah_baja_ksg_new = $jumlah_baja_ksg + $qty;


		$query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new' WHERE kode_baja = 'L03K01' ");
		$query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new' WHERE kode_baja = 'L03K11' ");
		$query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new' WHERE kode_baja = 'L03K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_rt_new' WHERE kode_baja = 'L03K00' ");

		//Hapusriwayat keberangkatan
		$query = mysqli_query($koneksi,"DELETE FROM riwayat_keberangkatan WHERE no_keberangkatan = '$no_keberangkatan'");

		//rekening
		$akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
		$data_rekening = mysqli_fetch_array($akses_rekening);
		$jumlah_uang = $data_rekening['jumlah'];
		$jumlah_uang_new = $jumlah_uang + $uang_jalan;
		$query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");


		echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;

		}
			

	}
