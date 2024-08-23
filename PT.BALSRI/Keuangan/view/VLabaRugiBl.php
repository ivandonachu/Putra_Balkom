
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
if ($jabatan_valid == 'Keuangan') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


if (isset($_GET['tanggal1'])) {
   $tanggal_awal = $_GET['tanggal1'];
   $tanggal_akhir = $_GET['tanggal2'];
} 

elseif (isset($_POST['tanggal1'])) {
   $tanggal_awal = $_POST['tanggal1'];
   $tanggal_akhir = $_POST['tanggal2'];
}  

else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }
function formatuang($angka){
  $uang = "Rp " . number_format($angka,2,',','.');
  return $uang;
}

if ($tanggal_awal == $tanggal_akhir) {
  // Tagihan
  $table = mysqli_query($koneksi, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_bl a INNER JOIN master_tarif_bl b ON a.delivery_point=b.delivery_point  WHERE tanggal = '$tanggal_awal'");
  $data = mysqli_fetch_array($table);
  $total_tagihan= $data['total_tagihan'];
  //pengiriman
  $table2 = mysqli_query($koneksi, "SELECT SUM(dexlite) AS total_dex, SUM(um) AS uang_makan, SUM(ug) AS uang_gaji FROM pengiriman_bl WHERE tanggal = '$tanggal_awal'");
  $data2 = mysqli_fetch_array($table2);
  $jml_dex= $data2['total_dex'];
  $total_um= $data2['uang_makan'];
  $total_ug= $data2['uang_gaji'];
  $total_dexlite = $jml_dex * 9700;

  //pengeluran Pul Biaya Kantor
   $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_bl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Kantor' ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_bl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Listrik & Telepon' ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrikr'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_bl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Biaya Sewa' ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_bl WHERE tanggal = '$tanggal_awal' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksi, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_bl WHERE tanggal = '$tanggal_awal'");
   $data7 = mysqli_fetch_array($table7);
   $jml_perbaikan = $data7['jumlah_perbaikan'];
    if (!isset($data7['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }


}
else{
    // Tagihan
  $table = mysqli_query($koneksi, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_bl a INNER JOIN master_tarif_bl b ON a.delivery_point=b.delivery_point  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data = mysqli_fetch_array($table);
  $total_tagihan= $data['total_tagihan'];

  // Potongan 10%
  $jumlah_potongan = (($total_tagihan * 10) / 100);
   //pengiriman
  $table2 = mysqli_query($koneksi, "SELECT SUM(um) AS uang_makan FROM pengiriman_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2 = mysqli_fetch_array($table2);

  $total_um= $data2['uang_makan'];

  $total_dexlite = 0;
  $table222 = mysqli_query($koneksi, "SELECT jt_gps, uj FROM pengiriman_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  while($data = mysqli_fetch_array($table222)){
    $uang_jalan = $data['uj'];
    $jt_gps = $data['jt_gps'];
    $total_dexlite = $total_dexlite + ($uang_jalan - ($jt_gps*625));

    
}

    
  //pengeluran Pul Biaya Kantor
   $table3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_biaya_kantor FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Kantor' ");
   $data3 = mysqli_fetch_array($table3);
   $jml_biaya_kantor = $data3['jumlah_biaya_kantor'];
    if (!isset($data3['jumlah_biaya_kantor'])) {
    $jml_biaya_kantor = 0;
    }

   //pengeluran Pul Listrik & Telepon
   $table4 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_listrik FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Listrik & Telepon' ");
   $data4 = mysqli_fetch_array($table4);
   $jml_listrik = $data4['jumlah_listrik'];
    if (!isset($data4['jumlah_listrik'])) {
    $jml_listrik = 0;
    }

   //pengeluran Biaya Sewa
   $table5 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_sewa FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Sewa' ");
   $data5 = mysqli_fetch_array($table5);
   $jml_sewa = $data5['jumlah_sewa'];
    if (!isset($data5['jumlah_sewa'])) {
    $jml_sewa = 0;
    }

   //pengeluran Alat Tulis Kantor
   $table6 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_atk FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Alat Tulis Kantor' ");
   $data6 = mysqli_fetch_array($table6);
   $jml_atk = $data6['jumlah_atk'];
    if (!isset($data6['jumlah_atk'])) {
    $jml_atk = 0;
    }

    //pengeluran Transnport / Perjalanan Dinas
   $table61 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_transport FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Transport / Perjalanan Dinas' ");
   $data61 = mysqli_fetch_array($table61);
   $jml_transport = $data61['jumlah_transport'];
    if (!isset($data61['jumlah_transport'])) {
    $jml_transport = 0;
    }
    //pengeluran Biaya Konsumsi
   $table62 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_konsumsi FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Biaya Konsumsi' ");
   $data62 = mysqli_fetch_array($table62);
   $jml_konsumsi = $data62['jumlah_konsumsi'];
    if (!isset($data62['jumlah_konsumsi'])) {
    $jml_konsumsi = 0;
    }

    //pengeluran perbaikan
   $table7 = mysqli_query($koneksi, "SELECT SUM(jml_pengeluaran) AS jumlah_perbaikan FROM riwayat_perbaikan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");
   $data7 = mysqli_fetch_array($table7);
   $jml_perbaikan = $data7['jumlah_perbaikan'];
    if (!isset($data7['jumlah_perbaikan'])) {
    $jml_perbaikan = 0;
    }
    
    
     //Gaji karyawan
   $table8 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'BALSRI BL' ");
   $data8 = mysqli_fetch_array($table8);
   $gaji_karyawan = $data8['jumlah_gaji'];
    if (!isset($data8['jumlah_gaji'])) {
    $gaji_karyawan = 0;
    }
    //Gaji dRIVER
   $table9 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_gaji FROM riwayat_penggajian WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND referensi = 'Driver BL' ");
   $data9 = mysqli_fetch_array($table9);
   $gaji_driver = $data9['jumlah_gaji'];
    if (!isset($data9['jumlah_gaji'])) {
    $gaji_driver = 0;
    }
    
    $total_gaji_karaywan = $gaji_karyawan + $gaji_driver;

    //list supir
    $table10 =  mysqli_query($koneksi, "SELECT mt FROM tagihan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");

    $table101 =  mysqli_query($koneksi, "SELECT mt FROM tagihan_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY mt ");
    //totalkredit
    $total_kredit = 0;
    while($data = mysqli_fetch_array($table101)){
        $mt = $data['mt'];
        $tablee = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_kredit FROM kredit_kendaraan WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND no_polisi ='$mt'");
        $dataa = mysqli_fetch_array($tablee);
        $jml_kredit= $dataa['total_kredit'];
        if(isset($total_kredit)){
            $total_kredit += $jml_kredit;
        }
        
    }

        
    //pengeluran Denda Kreit
   $table623 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlah_denda_kredit FROM pengeluaran_pul_bl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND nama_akun = 'Denda Kredit' ");
   $data623 = mysqli_fetch_array($table623);
   $total_denda_kredit = $data623['jumlah_denda_kredit'];
    if (!isset($data623['jumlah_denda_kredit'])) {
    $total_denda_kredit = 0;
    }


}
$total_laba_kotor = $total_tagihan;
$sisa_oprasional = $jumlah_potongan - ($jml_atk + $gaji_karyawan + $jml_sewa + $jml_transport );
$total_biaya_usaha_final = $total_dexlite + $jml_biaya_kantor + $jml_listrik + $jml_sewa +  $jml_perbaikan + $total_um + $gaji_driver  +  $jml_konsumsi+ $total_kredit + $jml_atk + $gaji_karyawan + $jml_transport + $total_denda_kredit;
$laba_bersih_sebelum_pajak = $total_laba_kotor - $total_biaya_usaha_final;
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Laba Rugi BALSRI</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdministrasi">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 65px; width: 220px;" src="../gambar/Logo CBM.jpg" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsAdministrasi">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Administrasi
    </div>
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >LR Kendaraan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">LR Kendaraan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi2">LR Kendaraan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP2">LR Kendaraan Sumsel</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">LR Kendaraan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBl">LR Kendaraan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBk">LR Kendaraan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">LR Kendaraan Bengkulu</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPA">LR Kendaraan Padlarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPL">LR Kendaraan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiTG">LR Kendaraan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiUB">LR Kendaraan Uj Berung</a>
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
<div class="container" style="color : black;">
   <?php  echo "<form  method='POST' action='VLabaRugiBl' style='margin-bottom: 15px;'>" ?>
   <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
    </div>
</div>
</form>

<br>
<br>
<?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
<br>
<hr>
<br>
<h3 class="text-center" >Laba Rugi Berdasarkan Kendaraan Belitung</h3>
<table id="example" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
<thead>
    <tr>
      <th class="text-center" >No Polisi</th>
      <th class="text-center" >Jenis Kendaraan</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table10)){
     $mt = $data['mt'];
     
     $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE no_polisi = '$mt' ");
    $data_ken = mysqli_fetch_array($result);
    $jenis_ken = $data_ken['jenis_kendaraan']; 

     echo "<tr>
     <td style='font-size: 14px' align = 'center'>$mt</td>
     <td style='font-size: 14px' align = 'center'>$jenis_ken</td>"?>
     <?php echo "<td class='text-center'><a href='VLRKendaraanBl?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&no_polisi=$mt'>LR Kendaraan</a></td>"; ?>
     
    
  <?php echo  " </tr>";
}
?>

</tbody>
</table>
<br>
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

<!-- Core plugin JavaScript-->
<script src="/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>