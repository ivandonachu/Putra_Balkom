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

$tanggal_awal = $_GET['tanggal1'];
$tanggal_akhir = $_GET['tanggal2'];
$tanggal = $_POST['tanggal'];
$nama_driver = $_POST['nama_driver'];
$no_polisi = $_POST['no_polisi'];
$posisi_bongkar = $_POST['posisi_bongkar'];
$uang_tambahan = $_POST['uang_tambahan'];
$keterangan = $_POST['keterangan'];
$L03K11 = 0;
$L03K00 = 0;
$L12K11 = $_POST['lpg12'];
$B05K11 = $_POST['bg5'];
$B12K11 = $_POST['bg12'];
$L12K00 = $_POST['lpg12rt'];
$B05K00 = $_POST['bg5rt'];
$B12K00 = $_POST['bg12rt'];
$status = $_POST['status'];
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

        move_uploaded_file($tmp_name, '../file_gudang/' . $nama_file_baru   );

        return $nama_file_baru; 

    }

    $file = upload();
    if (!$file) {
        return false;
    }

}       


if ($status == 'Hanya Kamvas') {



        $result = mysqli_query($koneksi, "SELECT * FROM rute_driver WHERE posisi_bongkar = '$posisi_bongkar' ");
        $data_rute = mysqli_fetch_array($result);
        $jumlah = $data_rute['jumlah'];
        $tambahan = $data_rute['tambahan'];
        $tujuan_berangkat = $data_rute['tujuan_berangkat'];

        $total_UJ = $jumlah + $tambahan + $uang_tambahan;

        $result2 = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$nama_driver' ");
        $data_driver = mysqli_fetch_array($result2);
        $id_driver = $data_driver['id_driver'];

        //input riwayat keberangkatan
        $query = mysqli_query($koneksi,"INSERT INTO riwayat_keberangkatan VALUES ('','$tanggal','$id_driver','$no_polisi','$posisi_bongkar','$tujuan_berangkat','$total_UJ','$L03K11','$L03K00','$L12K11','$L12K00','$B05K11','$B05K00','$B12K11','$B12K00','$status',1,'$keterangan','$file')");

        //rekening
        $akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
        $data_rekening = mysqli_fetch_array($akses_rekening);
        $jumlah_uang = $data_rekening['jumlah'];
        $jumlah_uang_new = $jumlah_uang - $total_UJ;
        $query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

        if ($query != "") {
            echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        }
    

}
if ($status == 'Kamvas + Pengisian') {
       

            //LPG12KG
            //baja isi
        $akses_inventory_isi12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K01'");
        $data_inventory_isi12 = mysqli_fetch_array($akses_inventory_isi12);
        $jumlah_baja_isi12 = $data_inventory_isi12['gudang'];
        $jumlah_baja_isi_new12 = $jumlah_baja_isi12 + $L12K11 + $L12K00;
            //baja + isi
        $akses_inventory_b12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K11'");
        $data_inventory_b12 = mysqli_fetch_array($akses_inventory_b12);
        $jumlah_baja_b12 = $data_inventory_b12['gudang'];
        $jumlah_baja_b_new12 = $jumlah_baja_b12 + $L12K11 + $L12K00;
        //retur
        $akses_inventory_b12rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K00'");
        $data_inventory_b12rt = mysqli_fetch_array($akses_inventory_b12rt);
        $jumlah_baja_b12rt = $data_inventory_b12rt['gudang'];
        $jumlah_baja_b_new12rt = $jumlah_baja_b12rt - $L12K00;
        //baja kosong
        $akses_inventory_ksg12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'L12K10'");
        $data_inventory_ksg12 = mysqli_fetch_array($akses_inventory_ksg12);
        $jumlah_baja_ksg12 = $data_inventory_ksg12['gudang'];
        $jumlah_baja_ksg_new12 = $jumlah_baja_ksg12 - $L12K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new12' WHERE kode_baja = 'L12K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new12' WHERE kode_baja = 'L12K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new12' WHERE kode_baja = 'L12K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new12rt' WHERE kode_baja = 'L12K00' ");

            //BG55KG
            //baja isi
        $akses_inventory_isi5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K01'");
        $data_inventory_isi5 = mysqli_fetch_array($akses_inventory_isi5);
        $jumlah_baja_isi5 = $data_inventory_isi5['gudang'];
        $jumlah_baja_isi_new5 = $jumlah_baja_isi5 + $B05K11 + $B05K00;
            //baja + isi
        $akses_inventory_b5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K11'");
        $data_inventory_b5 = mysqli_fetch_array($akses_inventory_b5);
        $jumlah_baja_b5 = $data_inventory_b5['gudang'];
        $jumlah_baja_b_new5 = $jumlah_baja_b5 + $B05K11 + $B05K00;
            //baja RETUR
        $akses_inventory_b5rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K00'");
        $data_inventory_b5rt = mysqli_fetch_array($akses_inventory_b5rt);
        $jumlah_baja_b5rt = $data_inventory_b5rt['gudang'];
        $jumlah_baja_b_new5rt = $jumlah_baja_b5rt - $B05K00;
        //baja kosong
        $akses_inventory_ksg5 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B05K10'");
        $data_inventory_ksg5 = mysqli_fetch_array($akses_inventory_ksg5);
        $jumlah_baja_ksg5 = $data_inventory_ksg5['gudang'];
        $jumlah_baja_ksg_new5 = $jumlah_baja_ksg5 - $B05K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_new5' WHERE kode_baja = 'B05K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new5' WHERE kode_baja = 'B05K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_new5' WHERE kode_baja = 'B05K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_new5rt' WHERE kode_baja = 'B05K00' ");
            //BG12KG
            //baja isi
        $akses_inventory_isib12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K01'");
        $data_inventory_isib12 = mysqli_fetch_array($akses_inventory_isib12);
        $jumlah_baja_isib12 = $data_inventory_isib12['gudang'];
        $jumlah_baja_isi_newb12 = $jumlah_baja_isib12 + $B12K11 + $B12K00;
            //baja + isi
        $akses_inventory_bb12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K11'");
        $data_inventory_bb12 = mysqli_fetch_array($akses_inventory_bb12);
        $jumlah_baja_bb12 = $data_inventory_bb12['gudang'];
        $jumlah_baja_b_newb12 = $jumlah_baja_bb12 + $B12K11 + $B12K00;
            //baja retur
        $akses_inventory_bb12rt = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K00'");
        $data_inventory_bb12rt = mysqli_fetch_array($akses_inventory_bb12rt);
        $jumlah_baja_bb12rt = $data_inventory_bb12rt['gudang'];
        $jumlah_baja_b_newb12rt = $jumlah_baja_bb12rt - $B12K00;
        //baja kosong
        $akses_inventory_ksgb12 = mysqli_query($koneksi, "SELECT * FROM inventory WHERE kode_baja = 'B12K10'");
        $data_inventory_ksgb12 = mysqli_fetch_array($akses_inventory_ksgb12);
        $jumlah_baja_ksgb12 = $data_inventory_ksgb12['gudang'];
        $jumlah_baja_ksg_newb12 = $jumlah_baja_ksgb12 - $B12K11;


        $query1 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_isi_newb12' WHERE kode_baja = 'B12K01' ");
        $query2 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_newb12' WHERE kode_baja = 'B12K11' ");
        $query4 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_ksg_newb12' WHERE kode_baja = 'B12K10' ");
        $query5 = mysqli_query($koneksi,"UPDATE inventory SET gudang = '$jumlah_baja_b_newb12rt' WHERE kode_baja = 'B12K00' ");





        $result = mysqli_query($koneksi, "SELECT * FROM rute_driver WHERE posisi_bongkar = '$posisi_bongkar' ");
        $data_rute = mysqli_fetch_array($result);
        $jumlah = $data_rute['jumlah'];
        $tambahan = $data_rute['tambahan'];
        $tujuan_berangkat = $data_rute['tujuan_berangkat'];

        $total_UJ = $jumlah + $tambahan + $uang_tambahan;

        $result2 = mysqli_query($koneksi, "SELECT * FROM driver WHERE nama_driver = '$nama_driver' ");
        $data_driver = mysqli_fetch_array($result2);
        $id_driver = $data_driver['id_driver'];

        //input riwayat keberangkatan
        $query = mysqli_query($koneksi,"INSERT INTO riwayat_keberangkatan VALUES ('','$tanggal','$id_driver','$no_polisi','$posisi_bongkar','$tujuan_berangkat','$total_UJ','$L03K11','$L03K00','$L12K11','$L12K00','$B05K11','$B05K00','$B12K11','$B12K00','$status',1,'$keterangan','$file')");


        //rekening
        $akses_rekening = mysqli_query($koneksi, "SELECT * FROM rekening WHERE kode_akun = '1-113'");
        $data_rekening = mysqli_fetch_array($akses_rekening);
        $jumlah_uang = $data_rekening['jumlah'];
        $jumlah_uang_new = $jumlah_uang - $total_UJ;
        $query1 = mysqli_query($koneksi,"UPDATE rekening SET jumlah = '$jumlah_uang_new' WHERE kode_akun = '1-113' ");

        if ($query != "") {
            echo "<script> window.location='../view/VKeberangkatan2?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir';</script>";exit;
        }

    

}




