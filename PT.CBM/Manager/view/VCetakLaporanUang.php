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
if ($jabatan_valid == 'Manager') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];


 if ($tanggal_awal == $tanggal_akhir) {
  $table999 =  mysqli_query($koneksi, "SELECT jam_manager, jam_kasir FROM konfirmasi_laporan WHERE tanggal =  '$tanggal_awal'");
  $data999 = mysqli_fetch_array($table999);
  $jam_kasir = $data999['jam_kasir'];
  $jam_manager = $data999['jam_manager'];

    // TOTAL P[ENDAPATAN
    $table = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' ");
    $data_pendapatan = mysqli_fetch_array($table);
    $data_total_pendapatan = $data_pendapatan['total_pendapatan'];
    if (!isset($data_total_pendapatan)) {
        $data_total_pendapatan = 0;
    }
    //DATA PENGELURAN
    $table2 = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_pengeluaran FROM riwayat_pengeluaran WHERE tanggal = '$tanggal_awal' AND kode_akun != '5-580' ");
    $data_pengeluaran = mysqli_fetch_array($table2);
    $data_total_pengeluaran = $data_pengeluaran['total_pengeluaran'];
    if (!isset($data_total_pengeluaran)) {
        $data_total_pengeluaran = 0;
    }
    
    //FATA BON
    $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal = '$tanggal_awal'");
    $data_bon = mysqli_fetch_array($table3);
    $data_total_bon = $data_bon['total_bon'];
    if (!isset($data_total_bon)) {
        $data_total_bon = 0;
    }

    //PENDAPATAN 3KG
    $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_3kg FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'L03K01' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'L03K01' ");
    $data_pendapatan_3kg = mysqli_fetch_array($table4);
    $pendapatan_3kg = $data_pendapatan_3kg['total_pendapatan_3kg'];
    if (!isset($data_pendapatan_3kg)) {
        $pendapatan_3kg = 0;
    }
    $table4x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_3kgx FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'L03K10' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'L03K10' ");
    $data_pendapatan_3kgx = mysqli_fetch_array($table4x);
    $pendapatan_3kgx = $data_pendapatan_3kgx['total_pendapatan_3kgx'];
    if (!isset($data_pendapatan_3kgx)) {
        $pendapatan_3kgx = 0;
    }
    $total_pendapatan_3kg = $pendapatan_3kgx + $pendapatan_3kg;

    //PENDAPTAN  5,5KG
    $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_5kg FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'B05K01' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'B05K01' ");
    $data_pendapatan_5kg = mysqli_fetch_array($table5);
    $pendapatan_5kg = $data_pendapatan_5kg['total_pendapatan_5kg'];
    if (!isset($data_pendapatan_5kg)) {
        $pendapatan_5kg = 0;
    }
    $table5x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_5kgx FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'B05K10' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'B05K10' ");
    $data_pendapatan_5kgx = mysqli_fetch_array($table5x);
    $pendapatan_5kgx = $data_pendapatan_5kgx['total_pendapatan_5kgx'];
    if (!isset($data_pendapatan_5kgx)) {
        $pendapatan_5kgx = 0;
    }
    $total_pendapatan_5kg = $pendapatan_5kgx + $pendapatan_5kg;

    //PENDAPTAN lpg 12KG
    $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_12kg FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'L12K01' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'L12K01' ");
    $data_pendapatan_12kg = mysqli_fetch_array($table6);
    $pendapatan_12kg = $data_pendapatan_12kg['total_pendapatan_12kg'];
    if (!isset($data_pendapatan_12kg)) {
        $pendapatan_12kg = 0;
    }
    $table6x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_12kgx FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'L12K10' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'L12K10' ");
    $data_pendapatan_12kgx = mysqli_fetch_array($table6x);
    $pendapatan_12kgx = $data_pendapatan_12kgx['total_pendapatan_12kgx'];
    if (!isset($data_pendapatan_12kgx)) {
        $pendapatan_12kgx = 0;
    }
    $total_pendapatan_12kg = $pendapatan_12kgx + $pendapatan_12kg;

    //PENDAPTAN bg 12KG
    $table7 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_b12kg FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'B12K01' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'B12K01' ");
    $data_pendapatan_b12kg = mysqli_fetch_array($table7);
    $pendapatan_b12kg = $data_pendapatan_b12kg['total_pendapatan_b12kg'];
    if (!isset($data_pendapatan_b12kg)) {
        $pendapatan_b12kg = 0;
    }
    $table7x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_b12kgx FROM riwayat_penjualan WHERE tanggal = '$tanggal_awal' AND pembayaran = 'Cash' AND kode_baja = 'B12K10' OR tanggal = '$tanggal_awal' AND pembayaran ='Deposit' AND kode_baja = 'B12K10' ");
    $data_pendapatan_b12kgx = mysqli_fetch_array($table7x);
    $pendapatan_b12kgx = $data_pendapatan_b12kgx['total_pendapatan_b12kgx'];
    if (!isset($data_pendapatan_b12kgx)) {
        $pendapatan_b12kgx = 0;
    }
    $total_pendapatan_b12kg = $pendapatan_b12kgx + $pendapatan_b12kg;

    $table8 = mysqli_query($koneksi, "SELECT * FROM riwayat_pengeluaran a INNER JOIN kode_akun b ON b.kode_akun = a.kode_akun WHERE tanggal = '$tanggal_awal' AND a.kode_akun != '5-580' ");


    
    $data_total_pengeluaran = $data_total_pengeluaran + $data_total_bon;
    
    $jumlah_bersih = $data_total_pendapatan - $data_total_pengeluaran;
    
    }
    else{
      $table999 =  mysqli_query($koneksi, "SELECT jam_manager, jam_kasir FROM konfirmasi_laporan WHERE tanggal =  '$tanggal_akhir'");
      $data999 = mysqli_fetch_array($table999);
      $jam_kasir = $data999['jam_kasir'];
      $jam_manager = $data999['jam_manager'];
    // TOTAL P[ENDAPATAN
    $table = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' ");
    $data_pendapatan = mysqli_fetch_array($table);
    $data_total_pendapatan = $data_pendapatan['total_pendapatan'];
    if (!isset($data_total_pendapatan)) {
        $data_total_pendapatan = 0;
    }
    
    
    $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah_bon) AS total_bon FROM bon_karyawan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    $data_bon = mysqli_fetch_array($table3);
    $data_total_bon = $data_bon['total_bon'];
    if (!isset($data_total_bon)) {
        $data_total_bon = 0;
    }
    $table2 = mysqli_query($koneksi, "SELECT SUM(jumlah_pengeluaran) AS total_pengeluaran FROM riwayat_pengeluaran WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND kode_akun != '5-580' ");
    $data_pengeluaran = mysqli_fetch_array($table2);
    $data_total_pengeluaran = $data_pengeluaran['total_pengeluaran'];
    if (!isset($data_total_pengeluaran)) {
        $data_total_pengeluaran = 0;
    }
    
    //PENDAPATAN 3KG
    $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_3kg FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'L03K01' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND pembayaran ='Deposit' AND kode_baja = 'L03K01' ");
    $data_pendapatan_3kg = mysqli_fetch_array($table4);
    $pendapatan_3kg = $data_pendapatan_3kg['total_pendapatan_3kg'];
    if (!isset($data_pendapatan_3kg)) {
        $pendapatan_3kg = 0;
    }
    $table4x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_3kgx FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'L03K10' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'L03K10' ");
    $data_pendapatan_3kgx = mysqli_fetch_array($table4x);
    $pendapatan_3kgx = $data_pendapatan_3kgx['total_pendapatan_3kgx'];
    if (!isset($data_pendapatan_3kgx)) {
        $pendapatan_3kgx = 0;
    }
    $total_pendapatan_3kg = $pendapatan_3kgx + $pendapatan_3kg;

    //PENDAPTAN  5,5KG
    $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_5kg FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash'  AND kode_baja = 'B05K01' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'B05K01' ");
    $data_pendapatan_5kg = mysqli_fetch_array($table5);
    $pendapatan_5kg = $data_pendapatan_5kg['total_pendapatan_5kg'];
    if (!isset($data_pendapatan_5kg)) {
        $pendapatan_5kg = 0;
    }
    $table5x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_5kgx FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash'  AND kode_baja = 'B05K10' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'B05K10' ");
    $data_pendapatan_5kgx = mysqli_fetch_array($table5x);
    $pendapatan_5kgx = $data_pendapatan_5kgx['total_pendapatan_5kgx'];
    if (!isset($data_pendapatan_5kgx)) {
        $pendapatan_5kgx = 0;
    }
    $total_pendapatan_5kg = $pendapatan_5kgx + $pendapatan_5kg;

    //PENDAPTAN lpg 12KG
    $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_12kg FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'L12K01' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'L12K01' ");
    $data_pendapatan_12kg = mysqli_fetch_array($table6);
    $pendapatan_12kg = $data_pendapatan_12kg['total_pendapatan_12kg'];
    if (!isset($data_pendapatan_12kg)) {
        $pendapatan_12kg = 0;
    }
    $table6x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_12kgx FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'L12K10' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'L12K10' ");
    $data_pendapatan_12kgx = mysqli_fetch_array($table6x);
    $pendapatan_12kgx = $data_pendapatan_12kgx['total_pendapatan_12kgx'];
    if (!isset($data_pendapatan_12kgx)) {
        $pendapatan_12kgx = 0;
    }
    $total_pendapatan_12kg = $pendapatan_12kgx + $pendapatan_12kg;

    //PENDAPTAN bg 12KG
    $table7 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_b12kg FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'B12K01' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'B12K01' ");
    $data_pendapatan_b12kg = mysqli_fetch_array($table7);
    $pendapatan_b12kg = $data_pendapatan_b12kg['total_pendapatan_b12kg'];
    if (!isset($data_pendapatan_b12kg)) {
        $pendapatan_b12kg = 0;
    }
    $table7x = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pendapatan_b12kgx FROM riwayat_penjualan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran = 'Cash' AND kode_baja = 'B12K10' OR tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND pembayaran ='Deposit' AND kode_baja = 'B12K10' ");
    $data_pendapatan_b12kgx = mysqli_fetch_array($table7x);
    $pendapatan_b12kgx = $data_pendapatan_b12kgx['total_pendapatan_b12kgx'];
    if (!isset($data_pendapatan_b12kgx)) {
        $pendapatan_b12kgx = 0;
    }
    $total_pendapatan_b12kg = $pendapatan_b12kgx + $pendapatan_b12kg;
    
    $table8 = mysqli_query($koneksi, "SELECT * FROM riwayat_pengeluaran a INNER JOIN kode_akun b ON b.kode_akun = a.kode_akun WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.kode_akun != '5-580' ");
    
    $data_total_pengeluaran = $data_total_pengeluaran + $data_total_bon;
    
    $jumlah_bersih = $data_total_pendapatan - $data_total_pengeluaran;
    }
 ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Penjualan CBM</title>

  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link

  rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom styles for this template-->

  <!-- Link Tabel -->


  <!-- Link datepicker -->

</head>

  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


<!-- Tabel -->    

<div class="row">
    <div  align='left' class="col-md-6">
            <img src="../gambar/KopSurat.png" style="height: 90px; width: 230px;">
    </div>
    <div align='right' class="col-md-6">
        <h9 style='font-size: 12px' >Alamat : Dsn. 01 RT/RW 03/01 Desa Suka Maju</h9><br>
        <h9 style='font-size: 12px' > Kec. Buay Madang Timur Kab. OKU Timur 32361 Sum-Sel </h9><br>
        <h9 style='font-size: 12px' > Email : ptcahayabumimusi@gmail.com | Telp/Hp. 0812 2160 0689</h9>

    </div>

</div>



<style>       
    hr{
        height: 2px;
        background-color: black;
        border: none;
    }
</style>
<hr>
<h5 align='center'>LAPORAN KEUANGAN GAS HARIAN</h5>
<?php 
if($tanggal_awal == $tanggal_akhir){
  
  echo"<h6 align='center'> "?> <?= formattanggal($tanggal_awal); echo"</h6>";
}
else{
   
    echo"<h6 align='center'>Priode"?> <?= formattanggal($tanggal_awal); echo" - ";  formattanggal($tanggal_akhir); echo"  </h6>";
}
?>
<br>
<br>

<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
    <tr>
      <th>No</th>
      <th>Akun</th>
      <th>Keterangan</th>
      <th>Debit</th>
      <th>Kredit</th>
      <th>Saldo</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_saldo = 0;

    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    function formattanggal($date){
        

      $newDate = date(" d F Y", strtotime($date));
      switch(date("l"))
  {
      case 'Monday':$nmh="Senin";break; 
      case 'Tuesday':$nmh="Selasa";break; 
      case 'Wednesday':$nmh="Rabu";break; 
      case 'Thursday':$nmh="Kamis";break; 
      case 'Friday':$nmh="Jum'at";break; 
      case 'Saturday':$nmh="Sabtu";break; 
      case 'Sunday':$nmh="minggu";break; 
  }
  echo $nmh.","."$newDate";
     }
    ?>
    <?php 

    $total_saldo = $total_saldo + $total_pendapatan_3kg;
    $urut = $urut +1 ;
    if($total_pendapatan_3kg == 0){

    }
    else{
     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>Penjualan Barang</td>
     <td style='font-size: 14px'>Elpiji 3KG</td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_pendapatan_3kg) ?> <?php echo"</td>
     <td style='font-size: 14px'></td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_saldo) ?> <?php echo"</td>
     </tr>";}

     $total_saldo = $total_saldo + $total_pendapatan_5kg;
    $urut = $urut +1 ;

    if($total_pendapatan_5kg == 0){

    }
    else{
     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>Penjualan Barang</td>
     <td style='font-size: 14px'>Bright Gas 5KG</td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_pendapatan_5kg) ?> <?php echo"</td>
     <td style='font-size: 14px'></td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_saldo) ?> <?php echo"</td>
     </tr>";}

     $total_saldo = $total_saldo + $total_pendapatan_12kg;
    $urut = $urut +1 ;

    if($total_pendapatan_12kg == 0){

    }
    else{
     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>Penjualan Barang</td>
     <td style='font-size: 14px'>Elpiji 12KG</td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_pendapatan_12kg) ?> <?php echo"</td>
     <td style='font-size: 14px'></td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_saldo) ?> <?php echo"</td>
     </tr>";}

     $total_saldo = $total_saldo + $total_pendapatan_b12kg;
    $urut = $urut +1 ;

    if($total_pendapatan_b12kg == 0){

    }
    else{
     echo "<tr>
     <td style='font-size: 14px'>$urut</td>
     <td style='font-size: 14px'>Penjualan Barang</td>
     <td style='font-size: 14px'>Bright Gas 12KG</td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_pendapatan_b12kg) ?> <?php echo"</td>
     <td style='font-size: 14px'></td>
     <td style='font-size: 14px'>";?> <?= formatuang($total_saldo) ?> <?php echo"</td>
     </tr>";}

    ?>
    <?php while($data = mysqli_fetch_array($table8)){
        $urut = $urut +1 ;
    
  
      $nama_akun = $data['nama_akun'];
      $jumlah_pengeluaran = $data['jumlah_pengeluaran'];
      $keterangan = $data['keterangan'];
      $total_saldo =  $total_saldo - $jumlah_pengeluaran;



      echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$nama_akun</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'></td>
      <td style='font-size: 14px'>";?> <?= formatuang($jumlah_pengeluaran) ?> <?php echo"</td>
      <td style='font-size: 14px'>";?> <?= formatuang($total_saldo) ?> <?php echo"</td>

      
</tr>";
  }
  echo "<tr>
  <td style='font-size: 14px' colspan ='5' > <strong> SALDO AWAL </strong></td>
  <td style='font-size: 14px'></td>
  </tr>";
  echo "<tr>
  <td style='font-size: 14px' colspan ='5' > <strong>TOTAL PEMASUKAN (DEBIT) </strong></td>
  <td style='font-size: 14px'><strong>";?> <?= formatuang($data_total_pendapatan) ?> <?php echo"</strong></td>
  </tr>";
  echo "<tr>
  <td style='font-size: 14px' colspan ='5' > <strong> TOTAL PENGELUARAN (KREDIT) </strong></td>
  <td style='font-size: 14px'><strong>";?> <?= formatuang($data_total_pengeluaran) ?> <?php echo"</strong></td>
  </tr>";
  echo "<tr>
  <td style='font-size: 14px' colspan ='5' > <strong> SALDO AKHIR</strong></td>
  <td style='font-size: 14px'><strong>";?> <?= formatuang($jumlah_bersih) ?> <?php echo"</strong></td>
  </tr>";

  ?>

</tbody>
</table>





<br>
<br>

  </div>
<!-- Tanda Konfirmasi  -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px; color:black;">
 
<div class="row" align="center">
  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Dibuat,</td>
        </tr>
        <tr>
            <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT kasir FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND kasir = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img src='../gambar/TTDKasir.png' style='height: 55px; width: 190px;'' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT kasir FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['kasir'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img  src='../gambar/TTDKasir.png' style='height: 55px; width: 190px;'> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
          
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;">Lilis Magdalena</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;">Kasir</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"><?=$jam_kasir;?></td>
        </tr>
      </thead>
    </table>
  </div>

  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Diperiksa,</td>
        </tr>
        <tr>
          <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT manager FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND manager = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img src='../gambar/TTDManager.png' style='height: 55px; width: 190px;' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT manager FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['manager'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img src='../gambar/TTDManager.png'  style='height: 55px; width: 190px;' > </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
        </tr> 
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;"> Made Suarte</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"> Manager</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"><?=$jam_manager;?></td>
        </tr>
      </thead>
    </table>
  </div>

  <div class="col-md-4">
    <table>
      <thead>
        <tr>
          <td align="center">Disetujui,</td>
        </tr>
        <tr>
          <?php 
                if ($tanggal_awal == $tanggal_akhir) {
                    
                    $kasir =  mysqli_query($koneksi, "SELECT direktur FROM konfirmasi_laporan WHERE tanggal = '$tanggal_awal'AND direktur = '1' ");
                if ( mysqli_num_rows($kasir) === 1 ) {
                      echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                   
                }
                else{
                   
                    $kasir3  =  mysqli_query($koneksi, "SELECT direktur FROM konfirmasi_laporan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                    $x=0;
                    $y=0;
                    $z=0;
                    while ($data4 = mysqli_fetch_array($kasir3)) {
                        $kasir11 = $data4['direktur'];
                     $x = $x+1;

                     if ($kasir11 == 1) {
                            $y = $y+1;
                        }   

                    }
                    if ( $y == $x ) {
                      echo "<td align='center'> <img  style='height: 55px; width: 190px;'' src=''> </td>";
                         }
                         else{
                    echo "<td align='center'>  </td>";
                        }
                }
                
            ?>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; text-decoration: underline;">Merry Yolanda D</td>
        </tr>
        <tr>
          <td align="center" style="font-weight: bold; font-style: italic;"> Komisaris</td>
        </tr>
      </thead>
    </table>
  </div>  
</div>
</div>



<!-- Bootstrap core JavaScript-->

<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>



</body>

</html>