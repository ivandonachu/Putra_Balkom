<?php
session_start();
include'koneksi.php';
if(!isset($_SESSION["login"])){
  header("Location: logout.php");
  exit;
}
$id=$_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksicbm, "SELECT * FROM super_account WHERE username = '$id'");
$data1 = mysqli_fetch_array($result1);
$nama = $data1['nama_pemilik'];
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}




if (isset($_GET['tanggal1'])) {
 $tanggal_awal = $_GET['tanggal1'];
 $tanggal_akhir = $_GET['tanggal2'];
 $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir))); 
} 

elseif (isset($_POST['tanggal1'])) {
 $tanggal_awal = $_POST['tanggal1'];
 $tanggal_akhir = $_POST['tanggal2'];
 $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir))); 
} 
else{
  $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');

  $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 day', strtotime($tanggal_akhir))); 
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksipbj,"SELECT * FROM penjualan_s WHERE tanggal_kirim = '$tanggal_akhir' ORDER BY no_penjualan ASC");





}

else{
  $table = mysqli_query($koneksipbj,"SELECT * FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");


  $table2 = mysqli_query($koneksipbj,"SELECT * FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");
  $table3 = mysqli_query($koneksipbj,"SELECT * FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");
  $table4 = mysqli_query($koneksipbj,"SELECT * FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");
  $table5 = mysqli_query($koneksipbj,"SELECT * FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");
  $table6 = mysqli_query($koneksipbj,"SELECT * FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");

  $total_untung_global = 0;
  $total_rugi_global =0;


      // pembelian kadek dan etty

    //pembelian 1
    $table_pembelian_1 = mysqli_query($koneksipbj, "SELECT harga_beli, qty, jumlah , harga FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    while ($data_pembelian_1 = mysqli_fetch_array($table_pembelian_1)) {


        $harga = $data_pembelian_1['harga'];
        $jumlah = $data_pembelian_1['jumlah'];
        $harga_beli = $data_pembelian_1['harga_beli'];
        $qty = $data_pembelian_1['qty'];
        $jumlah_beli = $harga_beli * $qty;
        if($harga > $harga_beli){
            $untung = $jumlah - $jumlah_beli;
            $total_untung_global = $total_untung_global + $untung;
        }
        else if($harga < $harga_beli){

            $rugi = $jumlah - $jumlah_beli;
            $total_rugi_global = $total_rugi_global + $rugi;

        }
     
    }

    //pembelian 2
    $table_pembelian_2 = mysqli_query($koneksipbj, "SELECT  harga_beli, qty, jumlah , harga FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
    while ($data_pembelian_2 = mysqli_fetch_array($table_pembelian_2)) {



        $harga = $data_pembelian_2['harga'];
        $jumlah = $data_pembelian_2['jumlah'];
        $harga_beli = $data_pembelian_2['harga_beli'];
        $qty = $data_pembelian_2['qty'];
        $jumlah_beli = $harga_beli * $qty;
        if($harga > $harga_beli){
            $untung = $jumlah - $jumlah_beli;
            $total_untung_global = $total_untung_global + $untung;
        }
        else if($harga < $harga_beli){

            $rugi = $jumlah - $jumlah_beli;
            $total_rugi_global = $total_rugi_global + $rugi;
     

        }


    }


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

  <title>Penjualan Semen</title>

  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/sbadmin/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Custom styles for this template-->
  <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Link Tabel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bootstrap-select/dist/css/bootstrap-select.css">

  <!-- Link datepicker -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsCVPBJ">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.png" ></div>
    </a>
    <br>
    
    <br>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active" >
        <a class="nav-link" href="DsCVPBJ">
            <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
            <span style="font-size: 16px;" >Dashboard</span></a>
        </li>

         <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading" style="font-size: 15px; color:white;">
             Menu CV.PBJ (Semen)
        </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
          15  aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-building" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >List Company</span>
        </a>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Company</h6>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
                <a class="collapse-item" style="font-size: 15px;" href="DsPBJ">CV.PBJ</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PERTASHOP/view/DsPertashop">Pertashop</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
                <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
            </div>
        </div>
    </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          15  aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >Report Etty</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluran">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3"
          15  aria-expanded="true" aria-controls="collapseTwo3">
            <i class="fa fa-clipboard-list" style="font-size: 15px; color:white;" ></i>
            <span style="font-size: 15px; color:white;" >Report Made Dani</span>
        </a>
        <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="font-size: 15px;">Report</h6>
                <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPenebusanL">Laporan Penebusan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Sewa Hiblow</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranL">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="VTonasePembelian">Tonase Pembelian</a>
            </div>
        </div>
    </li>
    <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='VLR2L'> Laba Rugi </a>
                          </li>";
                        } ?>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='VLR2LBaru'> Laba Rugi Baru </a>
                          </li>";
                        } ?>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='VRekapanHarga'> Rekapan Harga</a>
                          </li>";
                        } ?>
           



   
<!-- Divider -->
<hr class="sidebar-divider">


 
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow" style="background-color:#2C7873;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>




        <div class="topbar-divider d-none d-sm-block"></div>

<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
<img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile --> 
</a>
<!-- Dropdown - User Information -->
<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
aria-labelledby="userDropdown">
<a class="dropdown-item" href="VProfile">
<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
Profile
</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
Logout
</a>
</div>
</li>

  </ul>

</nav>
<!-- End of Topbar -->

<!-- Top content -->
<div>   


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

  <div align="left">
      <?php echo "<a href='../VLR2LBaru?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
  

  <br>
  <br>
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
</div>

<br>
<hr>
<br>

<br>

<h5 align='center'>DO Jual Untung (Etty)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>QTY</th>
      <th>Satuan</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>Catatan</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;


    ?>

    <?php while($data = mysqli_fetch_array($table)){
  $no_penjualan = $data['no_penjualan'];
  $tanggal_do =$data['tanggal_do'];
  $tanggal_kirim = $data['tanggal_kirim'];
  $no_do = $data['no_do'];
  $driver = $data['driver'];
  $no_polisi = $data['no_polisi'];
  $tujuan_pengiriman = $data['tujuan_pengiriman'];
  $qty = $data['qty'];
  $satuan = $data['satuan'];
  $harga_beli = $data['harga_beli'];
  $harga = $data['harga'];
  $jumlah = $data['jumlah'];
  $toko_do = $data['toko_do'];
  $tempo = $data['tempo'];
  $tanggal_bayar = $data['tanggal_bayar'];
  $status_bayar = $data['status_bayar'];
  $keterangan = $data['keterangan'];
  $catatan = $data['catatan'];
  $bulan = $data['bulan'];
  $file_bukti = $data['file_bukti'];
  $no_urut = $no_urut + 1;

  if($harga_beli<$harga){

    echo "<tr>
    <td style='font-size: 14px'>$no_urut</td>
    <td style='font-size: 14px'>$tanggal_do</td>
    <td style='font-size: 14px'>$tanggal_kirim</td>
    <td style='font-size: 14px'>$no_do</td>
    <td style='font-size: 14px'>$driver</td>
    <td style='font-size: 14px'>$no_polisi</td>
    <td style='font-size: 14px'>$tujuan_pengiriman</td>
    <td style='font-size: 14px'>$qty</td>
    <td style='font-size: 14px'>$satuan</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
    <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
    <td style='font-size: 14px'>$toko_do</td>
    <td style='font-size: 14px'>$tanggal_bayar</td>
    <td style='font-size: 14px'>$status_bayar</td>
    <td style='font-size: 14px'>$keterangan</td>
    <td style='font-size: 14px'>$catatan</td>
    <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/KasirSemen/file_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    "; ?>
 



<?php echo  " </tr>";

  }

}
?>

</tbody>
</table>
</div>
<br>
<hr>
<br>

<br>

<h5 align='center'>DO Jual Rugi (Etty)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example2" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>QTY</th>
      <th>Satuan</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>Catatan</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table2)){
  $no_penjualan = $data['no_penjualan'];
  $tanggal_do =$data['tanggal_do'];
  $tanggal_kirim = $data['tanggal_kirim'];
  $no_do = $data['no_do'];
  $driver = $data['driver'];
  $no_polisi = $data['no_polisi'];
  $tujuan_pengiriman = $data['tujuan_pengiriman'];
  $qty = $data['qty'];
  $satuan = $data['satuan'];
  $harga_beli = $data['harga_beli'];
  $harga = $data['harga'];
  $jumlah = $data['jumlah'];
  $toko_do = $data['toko_do'];
  $tempo = $data['tempo'];
  $tanggal_bayar = $data['tanggal_bayar'];
  $status_bayar = $data['status_bayar'];
  $keterangan = $data['keterangan'];
  $catatan = $data['catatan'];
  $bulan = $data['bulan'];
  $file_bukti = $data['file_bukti'];
  $no_urut = $no_urut + 1;

  if($harga_beli>$harga){

    echo "<tr>
    <td style='font-size: 14px'>$no_urut</td>
    <td style='font-size: 14px'>$tanggal_do</td>
    <td style='font-size: 14px'>$tanggal_kirim</td>
    <td style='font-size: 14px'>$no_do</td>
    <td style='font-size: 14px'>$driver</td>
    <td style='font-size: 14px'>$no_polisi</td>
    <td style='font-size: 14px'>$tujuan_pengiriman</td>
    <td style='font-size: 14px'>$qty</td>
    <td style='font-size: 14px'>$satuan</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
    <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
    <td style='font-size: 14px'>$toko_do</td>
    <td style='font-size: 14px'>$tanggal_bayar</td>
    <td style='font-size: 14px'>$status_bayar</td>
    <td style='font-size: 14px'>$keterangan</td>
    <td style='font-size: 14px'>$catatan</td>
    <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/KasirSemen/file_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    "; ?>
 



<?php echo  " </tr>";

  }

}
?>

</tbody>
</table>
</div>

<br>
<hr>
<br>

<br>

<h5 align='center'>DO Balik Modal (Etty)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example3" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>QTY</th>
      <th>Satuan</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>Catatan</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;


    ?>

    <?php while($data = mysqli_fetch_array($table3)){
  $no_penjualan = $data['no_penjualan'];
  $tanggal_do =$data['tanggal_do'];
  $tanggal_kirim = $data['tanggal_kirim'];
  $no_do = $data['no_do'];
  $driver = $data['driver'];
  $no_polisi = $data['no_polisi'];
  $tujuan_pengiriman = $data['tujuan_pengiriman'];
  $qty = $data['qty'];
  $satuan = $data['satuan'];
  $harga_beli = $data['harga_beli'];
  $harga = $data['harga'];
  $jumlah = $data['jumlah'];
  $toko_do = $data['toko_do'];
  $tempo = $data['tempo'];
  $tanggal_bayar = $data['tanggal_bayar'];
  $status_bayar = $data['status_bayar'];
  $keterangan = $data['keterangan'];
  $catatan = $data['catatan'];
  $bulan = $data['bulan'];
  $file_bukti = $data['file_bukti'];
  $no_urut = $no_urut + 1;

  if($harga_beli==$harga){

    echo "<tr>
    <td style='font-size: 14px'>$no_urut</td>
    <td style='font-size: 14px'>$tanggal_do</td>
    <td style='font-size: 14px'>$tanggal_kirim</td>
    <td style='font-size: 14px'>$no_do</td>
    <td style='font-size: 14px'>$driver</td>
    <td style='font-size: 14px'>$no_polisi</td>
    <td style='font-size: 14px'>$tujuan_pengiriman</td>
    <td style='font-size: 14px'>$qty</td>
    <td style='font-size: 14px'>$satuan</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
    <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
    <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
    <td style='font-size: 14px'>$toko_do</td>
    <td style='font-size: 14px'>$tanggal_bayar</td>
    <td style='font-size: 14px'>$status_bayar</td>
    <td style='font-size: 14px'>$keterangan</td>
    <td style='font-size: 14px'>$catatan</td>
    <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/KasirSemen/file_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    "; ?>
 



<?php echo  " </tr>";

  }

}
?>

</tbody>
</table>
</div>

<br>
<hr>
<br>
<br>

<h5 align='center'>DO Jual Untung (Dani)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example4" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>Material</th>
      <th>QTY</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;

    ?>

    <?php while($data = mysqli_fetch_array($table4)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal_do =$data['tanggal_do'];
      $tanggal_kirim = $data['tanggal_kirim'];
      $no_do = $data['no_do'];
      $driver = $data['driver'];
      $no_polisi = $data['no_polisi'];
      $tujuan_pengiriman = $data['tujuan_pengiriman'];
      $qty = $data['qty'];
      $satuan = $data['satuan'];
      $harga_beli = $data['harga_beli'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $toko_do = $data['toko_do'];
      $tempo = $data['tempo'];
      $tanggal_bayar = $data['tanggal_bayar'];
      $status_bayar = $data['status_bayar'];
      $keterangan = $data['keterangan'];
      $bulan = $data['bulan'];
      $file_bukti = $data['file_bukti'];
      $no_urut = $no_urut + 1;
    
        if($harga_beli<$harga){
        echo "<tr>
        <td style='font-size: 14px'>$no_urut</td> 
        <td style='font-size: 14px'>$tanggal_do</td>
        <td style='font-size: 14px'>$tanggal_kirim</td>
        <td style='font-size: 14px'>$no_do</td>
        <td style='font-size: 14px'>$driver</td>
        <td style='font-size: 14px'>$no_polisi</td>
        <td style='font-size: 14px'>$tujuan_pengiriman</td>
        <td style='font-size: 14px'>$satuan</td>
        <td style='font-size: 14px'>$qty</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
        <td style='font-size: 14px'>$toko_do</td>
        <td style='font-size: 14px'>$tanggal_bayar</td>
        <td style='font-size: 14px'>$status_bayar</td>
        <td style='font-size: 14px'>$keterangan</td>
        <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
        "; ?>
     
  
  
  
  <?php echo  " </tr>";
      }

     
}
?>

</tbody>
</table>
</div>


<br>
<hr>
<br>
<br>

<h5 align='center'>DO Jual Rugi (Dani)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example5" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>Material</th>
      <th>QTY</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;

    ?>

    <?php while($data = mysqli_fetch_array($table5)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal_do =$data['tanggal_do'];
      $tanggal_kirim = $data['tanggal_kirim'];
      $no_do = $data['no_do'];
      $driver = $data['driver'];
      $no_polisi = $data['no_polisi'];
      $tujuan_pengiriman = $data['tujuan_pengiriman'];
      $qty = $data['qty'];
      $satuan = $data['satuan'];
      $harga_beli = $data['harga_beli'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $toko_do = $data['toko_do'];
      $tempo = $data['tempo'];
      $tanggal_bayar = $data['tanggal_bayar'];
      $status_bayar = $data['status_bayar'];
      $keterangan = $data['keterangan'];
      $bulan = $data['bulan'];
      $file_bukti = $data['file_bukti'];
      $no_urut = $no_urut + 1;
    
      if($harga_beli>$harga){
        echo "<tr>
        <td style='font-size: 14px'>$no_urut</td> 
        <td style='font-size: 14px'>$tanggal_do</td>
        <td style='font-size: 14px'>$tanggal_kirim</td>
        <td style='font-size: 14px'>$no_do</td>
        <td style='font-size: 14px'>$driver</td>
        <td style='font-size: 14px'>$no_polisi</td>
        <td style='font-size: 14px'>$tujuan_pengiriman</td>
        <td style='font-size: 14px'>$satuan</td>
        <td style='font-size: 14px'>$qty</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
        <td style='font-size: 14px'>$toko_do</td>
        <td style='font-size: 14px'>$tanggal_bayar</td>
        <td style='font-size: 14px'>$status_bayar</td>
        <td style='font-size: 14px'>$keterangan</td>
        <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
        "; ?>
     
  
  
  
  <?php echo  " </tr>";
      }

     
}
?>

</tbody>
</table>
</div>

<br>
<hr>
<br>
<br>

<h5 align='center'>DO Balik Modal (Dani)</h5>
<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example6" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>TGL DO</th>
      <th>TGL Kirim</th>
      <th>NO DO</th>
      <th>Driver</th>
      <th>NO Polisi</th>
      <th>Tujuan Pengiriman</th>
      <th>Material</th>
      <th>QTY</th>
      <th>Harga Beli</th>
      <th>Harga Jual</th>
      <th>Jumlah</th>    
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;

    ?>

    <?php while($data = mysqli_fetch_array($table6)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal_do =$data['tanggal_do'];
      $tanggal_kirim = $data['tanggal_kirim'];
      $no_do = $data['no_do'];
      $driver = $data['driver'];
      $no_polisi = $data['no_polisi'];
      $tujuan_pengiriman = $data['tujuan_pengiriman'];
      $qty = $data['qty'];
      $satuan = $data['satuan'];
      $harga_beli = $data['harga_beli'];
      $harga = $data['harga'];
      $jumlah = $data['jumlah'];
      $toko_do = $data['toko_do'];
      $tempo = $data['tempo'];
      $tanggal_bayar = $data['tanggal_bayar'];
      $status_bayar = $data['status_bayar'];
      $keterangan = $data['keterangan'];
      $bulan = $data['bulan'];
      $file_bukti = $data['file_bukti'];
      $no_urut = $no_urut + 1;
    
      if($harga_beli==$harga){
        echo "<tr>
        <td style='font-size: 14px'>$no_urut</td> 
        <td style='font-size: 14px'>$tanggal_do</td>
        <td style='font-size: 14px'>$tanggal_kirim</td>
        <td style='font-size: 14px'>$no_do</td>
        <td style='font-size: 14px'>$driver</td>
        <td style='font-size: 14px'>$no_polisi</td>
        <td style='font-size: 14px'>$tujuan_pengiriman</td>
        <td style='font-size: 14px'>$satuan</td>
        <td style='font-size: 14px'>$qty</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
        <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
        <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
        <td style='font-size: 14px'>$toko_do</td>
        <td style='font-size: 14px'>$tanggal_bayar</td>
        <td style='font-size: 14px'>$status_bayar</td>
        <td style='font-size: 14px'>$keterangan</td>
        <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
        "; ?>
     
  
  
  
  <?php echo  " </tr>";
      }

     
}
?>

</tbody>
</table>
</div>
<br>
<hr>
<br>
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Jual Untung</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($total_untung_global) ?></div>
          </div>
          <div class="col-auto">
           <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Jual Rugi</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($total_rugi_global) ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<br>

</div>
</div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="footer" style="background-color:#2C7873; height: 55px; padding-top: 15px; ">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span style="color:white; font-size: 12px;">Copyright &copy; PutraBalkomCorp 2021</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <a class="btn btn-primary" href="logout">Logout</a>
    </div>
  </div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>
<script src="/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- Tabel -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    var table = $('#example').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example3').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example4').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example5').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>


<script>
  $(document).ready(function() {
    var table = $('#example6').DataTable( {
      lengthChange: true,
      buttons: [  ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  function createOptions(number) {
    var options = [], _options;

    for (var i = 0; i < number; i++) {
      var option = '<option value="' + i + '">Option ' + i + '</option>';
      options.push(option);
    }

    _options = options.join('');

    $('#number')[0].innerHTML = _options;
    $('#number-multiple')[0].innerHTML = _options;

    $('#number2')[0].innerHTML = _options;
    $('#number2-multiple')[0].innerHTML = _options;
  }

  var mySelect = $('#first-disabled2');

  createOptions(4000);

  $('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
  });

  $('#special2').on('click', function () {
    mySelect.find('option:disabled').prop('disabled', false);
    mySelect.selectpicker('refresh');
  });

  $('#basic2').selectpicker({
    liveSearch: true,
    maxOptions: 1
  });
</script>

<script>

            function sum() {
              var banyak_barang = document.getElementById('qty').value;
              var harga = document.getElementById('harga').value;
              var result = parseInt(banyak_barang) * parseInt(harga);
              if (!isNaN(result)) {
               document.getElementById('jumlah').value = result;
             }
           }
         </script>

         
</body>

</html>