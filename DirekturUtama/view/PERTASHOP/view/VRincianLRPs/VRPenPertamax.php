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
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}
if (isset($_GET['tanggal1'])) {
   $tanggal_awal = $_GET['tanggal1'];
   $tanggal_akhir = $_GET['tanggal2'];
   $lokasi = $_GET['lokasi'];
} 

elseif (isset($_POST['tanggal1'])) {
   $tanggal_awal = $_POST['tanggal1'];
   $tanggal_akhir = $_POST['tanggal2'];
   $lokasi = $_POST['lokasi'];
}  

else{
  $tanggal_awal = date('Y-m-1');
$tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksiperta,"SELECT * FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal ='$tanggal_awal' ");
    $result = mysqli_query($koneksiperta, "SELECT * FROM pertashop  ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];
   $table2 = mysqli_query($koneksiperta,"SELECT * FROM barang WHERE kode_perta = '$kode_perta'");


}

else{
  $table = mysqli_query($koneksiperta,"SELECT * FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND nama_barang = 'Pertamax' AND b.lokasi = '$lokasi' ");
  $result = mysqli_query($koneksiperta, "SELECT * FROM pertashop WHERE lokasi = '$lokasi' ");
$data_perta = mysqli_fetch_array($result);
$kode_perta = $data_perta['kode_perta'];
   $table2 = mysqli_query($koneksiperta,"SELECT * FROM barang WHERE kode_perta = '$kode_perta' AND nama_barang = 'Pertamax' ");

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

  <title>Rincian Penjualan Pertamax  <?php echo $lokasi ?></title>

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

  <!-- Link datepicker -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPertashop">
            <div class="sidebar-brand-icon rotate-n-15">

            </div>
            <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
        </a>

        <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading" style="font-size: 15px; color:white;">
                 Menu Pertashop
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
              15  aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                <span style="font-size: 15px; color:white;" >List Perusahaan</span>
            </a>
            <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header" style="font-size: 15px;">Perusahaan</h6>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.CBM/view/DsPTCBM">PT.CBM</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/CV.PBJ/view/DsCVPBJ">CV.PBJ</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BatuBara/view/DsCVPBJ">Transport BB</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.BALSRI/view/DsPTBALSRI">PT.BALSRI</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.MESPBR/view/DsPTPBRMES">PT. MES & PBR</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/Kebun/view/DsKebun">Kebun</a>
                    <a class="collapse-item" style="font-size: 15px;" href="DsPertashop">Pertashop</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/PT.STRE/view/DsPTSTRE">PT.Sri Trans Energi</a>
                    <a class="collapse-item" style="font-size: 15px;" href="/DirekturUtama/view/BALSRI_JBB/view/DsBALSRIJBB">BALSRI JBB</a>
                </div>
            </div>
        </li>
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
              15  aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                <span style="font-size: 15px; color:white;" >Laporan</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
                    <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"<a class='collapse-item' style='font-size: 15px;' href='../VLabaRugiPs'>Laba Rugi</a>";
                        } ?>
                    <a class="collapse-item" style="font-size: 15px;" href="../Setoran">Setoran</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VLPenjualan">Lap Penjualan Pertamax</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VLPenjualanDex">Lap Penjualan Dexlite</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VCorPertamax">Lap Ngecor Pertamax</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VCorDexlite">Lap Ngecor Dexlite</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VLPengeluaran">Laporan Pengeluran</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VLKeuangan">Laporan Keuangan</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VPembelian">Laporan Pembelian</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VAbsensi">Absensi</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VGrafikPenjualan">Grafik Penjualan</a>
                    <a class="collapse-item" style="font-size: 15px;" href="../VGrafikPenjualanPagi">Grafik Jual Pagi</a>
                </div>
            </div>
        </li>

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
      <?php echo "<a href='VPengiriman'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Rincian Penjualan Pertamax PS  $lokasi </h5></a>"; ?>
      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>



      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">






        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline  small"  style="color:white;"><?php echo "$nama"; ?></span>
          <img class="img-profile rounded-circle"
          src="img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="VProfile">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="VSetting">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Settings
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


 <div style="margin-right: 10px; margin-left: 10px;">

  <div>
    <div align="left">
    <?php echo "<a href='../VLabaRugiPs?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
    </div>
    </div>
  
  
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
   
</div>




<!-- Tabel -->    
<div style="overflow-x: auto" align = 'center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
    <th  style="font-size: 11px" >No</th>
      <th  style="font-size: 11px">Tanggal</th>
      <th  style="font-size: 11px">Kode Pertashop</th>   
      <th  style="font-size: 11px">Lokasi</th>
      <th  style="font-size: 11px">Penjual</th>
      <th  style="font-size: 11px">Barang</th>
      <th  style="font-size: 11px">Terjual</th>
      <th  style="font-size: 11px">Harga</th>
      <th  style="font-size: 11px">Total</th>
      <th  style="font-size: 11px">Total Uang Diskon</th>
      <th  style="font-size: 11px">Stok awal</th>
      <th  style="font-size: 11px">Stok Akhir</th>
      <th  style="font-size: 11px">Bongkaran</th>
      <th  style="font-size: 11px">sonding Awal</th>
      <th  style="font-size: 11px">Sonding Akhir</th>
      <th  style="font-size: 11px">Sirkulasi</th>
      <th  style="font-size: 11px">Losis Penyimpanan</th>
      <th  style="font-size: 11px">Losis Penjualan</th>
      <th  style="font-size: 11px">KET</th>
      <th  style="font-size: 11px">File</th>
      <th  style="font-size: 11px">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $urut = 0;
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }
    $urut = 0;
    $uang_nb_max = 0;
    $terjual_nb_max = 0;
    $uang_nb_dex = 0;
    $terjual_nb_dex = 0 ;
    $uang_be =0;
    $terjual_be = 0;
    $uang_md = 0;
    $terjual_md = 0;
    $uang_sj = 0 ;
    $terjual_sj = 0;
    $total_uang_diskon_nb_max = 0 ;
    $total_uang_diskon_be = 0 ;
    $total_losis_penjualan = 0;
    $total_losis_penyimpanan = 0;

    ?>
    <?php while($data = mysqli_fetch_array($table)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal =$data['tanggal'];
      $kode_perta =$data['kode_perta'];
      $lokasi = $data['lokasi'];
      $nama_barang = $data['nama_barang'];
      $nama_karyawan = $data['nama_karyawan'];
      $qty = $data['qty'];
      $stok_awal = $data['stok_awal'];
      $stok_akhir = $data['stok_akhir'];
      $bongkaran = $data['bongkaran'];
      $sonding_awal = $data['sonding_awal'];
      $sonding_akhir = $data['sonding_akhir'];
      $sirkulasi = $data['sirkulasi'];
      $losis_penyimpanan = $data['losis_penyimpanan'];
      $losis_penjualan = $data['losis_penjualan'];
      $harga = $data['harga'];
      $uang_diskon = $data['uang_diskon'];
      $jumlah = $qty * $harga;
      $keterangan = $data['keterangan'];
      $file_bukti = $data['file_bukti'];
      $status = $data['persetujuan'];
      $urut = $urut + 1;
      $total_losis_penyimpanan = $total_losis_penyimpanan + $losis_penyimpanan;
      $total_losis_penjualan = $total_losis_penjualan + $losis_penjualan;
    
      if($kode_perta == 'nusabakti'){
        if($nama_barang == 'Pertamax'){
          $uang_nb_max = $uang_nb_max + $jumlah ; 
          $terjual_nb_max =  $terjual_nb_max + $qty;

          $total_uang_diskon_nb_max = $total_uang_diskon_nb_max + $uang_diskon;
   
        }
        else{
          $uang_nb_dex =  $uang_nb_dex + $jumlah; 
          $terjual_nb_dex = $terjual_nb_dex + $qty;

          $total_uang_diskon_nb_dex = $total_uang_diskon_nb_dex + $uang_diskon;
        
     
        }
        
      }
      else if($kode_perta == 'bedilan'){
        $uang_be = $uang_be + $jumlah; 
        $terjual_be = $terjual_be + $qty;
        $total_uang_diskon_be = $total_uang_diskon_be + $uang_diskon;
    
      }
      else if($kode_perta == 'muaradua'){
        $uang_md = $uang_md + $jumlah; 
        $terjual_md = $terjual_md + $qty;
        $total_uang_diskon_md = $total_uang_diskon_md + $uang_diskon;
       
      }
      else if($kode_perta == 'sumberjaya'){
        $uang_sj = $uang_sj + $jumlah; 
        $terjual_sj = $terjual_sj + $qty;
        $total_uang_diskon_sj = $total_uang_diskon_sj + $uang_diskon;
     
      }

      echo "<tr>
      <td style='font-size: 11px' align = 'center'>$urut</td>
      <td style='font-size: 11px' align = 'center'>$tanggal</td>
      <td style='font-size: 11px' align = 'center'>$kode_perta</td>
      <td style='font-size: 11px' align = 'center'>$lokasi</td>
      <td style='font-size: 11px' align = 'center'>$nama_karyawan</td>
      <td style='font-size: 11px' align = 'center'>$nama_barang</td>
      <td style='font-size: 11px' align = 'center'>$qty/L</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>"?>  <?= formatuang($uang_diskon); ?> <?php echo "</td>
      <td style='font-size: 11px' align = 'center'>$stok_awal/L</td>
      <td style='font-size: 11px' align = 'center'>$stok_akhir/L</td>
      <td style='font-size: 11px' align = 'center'>$bongkaran/L</td>
      <td style='font-size: 11px' align = 'center'>$sonding_awal/L</td>
      <td style='font-size: 11px' align = 'center'>$sonding_akhir/L</td>
      <td style='font-size: 11px' align = 'center'>$sirkulasi/L</td>
      <td style='font-size: 11px' align = 'center'>$losis_penyimpanan/L</td>
      <td style='font-size: 11px' align = 'center'>$losis_penjualan/L</td>
      <td style='font-size: 11px' align = 'center'>$keterangan</td>
      "; ?>
      <?php echo "<td style='font-size: 11px'>"; ?>

        <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_penjualan']; ?>">Lihat</button>

        <!-- Form EDIT DATA -->

        <div class="modal fade" id="formedit<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role ="document">
            <div class="modal-content"> 
              <div class="modal-header">
                <h5 class="modal-title"> Foto Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>


              <!-- Form Edit Data -->
              <div class="modal-body">
                       <img  style="height: 100%; width: 100%;" s src="/PERTASHOP/Karyawan/file_karyawan/<?= $file_bukti ?>" >
                </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><a  style="color: black;" download="/PERTASHOP/Karyawan/file_karyawan/<?= $file_bukti ?>" href="/PERTASHOP/Karyawan/file_karyawan/<?= $file_bukti ?>">Download</a>  </button>
              
                  </div>
                </form>
              </div>
            </div>
          </div>
       




        <?php echo "</td> "; ?>
      <?php
      if ($status == 0) {
       echo "<td style='font-size: 14px; color: red;' align = 'center'>Belum di Setujui</td>";
      }
      else{
         echo "<td style='font-size: 14px; color: green;' align = 'center'>Telah di Setujui</td>";
      }
      ?>

    
<?php echo  "</tr>";
}
?>

</tbody>
</table>
</div>
</div>

<br>
<hr>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Stok</h6>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>STOK</th>
    </tr>
  </thead>
  <tbody>
    <?php $data = mysqli_fetch_array($table2);
      $nama_barang =$data['nama_barang'];
      $stok = $data['stok'];


      echo "<tr>
      <td style='font-size: 11px' align = 'center'>$nama_barang</td>
      <td style='font-size: 11px' align = 'center'>$stok / L</td>
     
  </tr>";

?>

</tbody>
</table>
</div>
<br>
<hr>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Barang Terjual</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'>Pertashop</th>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>Total Terjual</th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'><?=  ($terjual_nb_dex); ?> / L</td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($terjual_nb_max);  ?> / L</td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($terjual_sj); ?> / L</td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($terjual_be); ?> / L</td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($terjual_md); ?> / L</td>
     
  </tr>


</tbody>
</table>
</div>
<br>
<hr>

<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center">Laporan Barang Di Cor</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'>Pertashop</th>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>Total Terjual</th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_dex); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_nb_max); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_sj); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_be); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  ($cor_md); ?></td>
     
  </tr>


</tbody>
</table>
</div>

<br>
<hr>
<div style="margin-right: 100px; margin-left: 100px;">
<h6 align="Center"  >Laporan Keuangan</h6>
<table  class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
  <thead>
      <th style='font-size: 11px'>Pertashop</th>
      <th style='font-size: 11px'>Nama Barang</th>
      <th style='font-size: 11px'>Total Pendapatan</th>
    </tr>
  </thead>
  <tbody>

  
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Dexlite</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($uang_nb_dex); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Nusa Bakti</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($uang_nb_max); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Sumber Jaya</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($uang_sj); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Bedilan</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($uang_be); ?></td>
     
  </tr>
  <tr>
      <td style='font-size: 11px' align = 'center'>Muara Dua</td>
      <td style='font-size: 11px' align = 'center'>Pertamax</td>
      <td style='font-size: 11px' align = 'center'><?=  formatuang($uang_md); ?></td>
     
  </tr>



</tbody>
</table>
</div>
<br>
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
<script src="/sbadmin/vendor/jquery/jquery.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

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
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>



</body>

</html>