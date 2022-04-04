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
 
 //DATA PERTAMAX
//data tanggal
$table= mysqli_query($koneksiperta, "SELECT tanggal FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
                                        WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.nama_barang = 'Pertamax' GROUP BY tanggal ");


while($data = mysqli_fetch_assoc($table)){
    $tanggal = $data['tanggal'];

    $data_tanggal[] = "$tanggal";
}

//data pendapatan sumberjaya pertamax
$table2 = mysqli_query($koneksiperta, "SELECT sum(qty) AS total_qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = 'Sumber Jaya' AND a.nama_barang = 'Pertamax' GROUP BY tanggal  ");

while($data2 = mysqli_fetch_array($table2)){
    $qty = $data2['total_qty'];
    $harga = $data2['harga'];
    $jumlah = $qty * $harga;
    $data_pendapatan_sj[] = "$jumlah";
    $data_penjualan_sj[] = "$qty";
}

//data pendapatan bedilan pertamax
$table3 = mysqli_query($koneksiperta, "SELECT sum(qty) AS total_qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = 'Bedilan'  AND a.nama_barang = 'Pertamax' GROUP BY tanggal  ");

while($data3 = mysqli_fetch_array($table3)){
    $qty = $data3['total_qty'];
    $harga = $data3['harga'];
    $jumlah = $qty * $harga;
    $data_pendapatan_b[] = "$jumlah";
    $data_penjualan_b[] = "$qty";
}

//data pendapatan nusa bakti pertamax
$table4 = mysqli_query($koneksiperta, "SELECT sum(qty) AS total_qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = 'Nusa Bakti'  AND a.nama_barang = 'Pertamax' GROUP BY tanggal  ");

while($data4 = mysqli_fetch_array($table4)){
    $qty = $data4['total_qty'];
    $harga = $data4['harga'];
    $jumlah = $qty * $harga;
    $data_pendapatan_nb[] = "$jumlah";
    $data_penjualan_nb[] = "$qty";
}

//DATA DEXLITE

//data tanggal
$table11= mysqli_query($koneksiperta, "SELECT tanggal FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
                                        WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.nama_barang = 'Dexlite' GROUP BY tanggal ");


while($data11 = mysqli_fetch_assoc($table11)){
    $tanggal = $data11['tanggal'];

    $data_tanggal_dex[] = "$tanggal";
}


//data pendapatan nusa bakti dexlite
$table21 = mysqli_query($koneksiperta, "SELECT sum(qty) AS total_qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta
WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = 'Nusa Bakti'  AND a.nama_barang = 'Dexlite' GROUP BY tanggal  ");

while($data21 = mysqli_fetch_array($table21)){
    $qty = $data21['total_qty'];
    $harga = $data21['harga'];
    $jumlah = $qty * $harga;
    $data_pendapatan_nb_dex[] = "$jumlah";
    $data_penjualan_nb_dex[] = "$qty";
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

    <title>Grafik Penjualan</title>

    <!-- Custom fonts for this template-->
    <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <script type="text/javascript">
    window.setTimeout("waktu()",1000);
    function waktu() {
        var tanggal = new Date();
        setTimeout("waktu()",1000);
        document.getElementById("jam").innerHTML = tanggal.getHours();
        document.getElementById("menit").innerHTML = tanggal.getMinutes();
        document.getElementById("detik").innerHTML = tanggal.getSeconds();
    }
</script>

</head>

<style>
    #jam-digital{overflow:hidden}
    #hours{float:left; width:50px; height:30px; background-color:#008B8B; margin-right:25px}
    #minute{float:left; width:50px; height:30px; background-color:  #008B8B; margin-right:25px}
    #second{float:left; width:50px; height:30px; background-color: #008B8B;}
    #jam-digital p{color:#FFF; font-size: 22px; text-align:center}
</style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
   <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsManager">
             <div class="sidebar-brand-icon rotate-n-15">

             </div>
             <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
         </a>

         <!-- Divider -->
         <hr class="sidebar-divider my-0">

         <!-- Nav Item - Dashboard -->
         <li class="nav-item active" >
             <a class="nav-link" href="DsManager">
                 <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                 <span style="font-size: 16px;" >Dashboard</span></a>
             </li>

             <!-- Divider -->
             <hr class="sidebar-divider">

             <!-- Heading -->
             <div class="sidebar-heading" style="font-size: 15px; color:white;">
                  Menu Manager
             </div>
             <?php if ($nama =='Tanry Yanoda Donachu') {
                ?>  <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
               15  aria-expanded="true" aria-controls="collapseOne">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >Tagihan</span>
             </a>
             <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Palembang</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">Laba Rugi LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP">Laba Rugi PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">Laba Rugi BTA</a>
                 </div>
             </div>
         </li> <?php
             }
             ?>
             <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               15  aria-expanded="true" aria-controls="collapseTwo">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >Pengiriman</span>
             </a>
             <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Rekap Gaji</a>
                 </div>
             </div>
         </li>
          <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo22"
               15  aria-expanded="true" aria-controls="collapseTwo22">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >Pengeluaran</span>
             </a>
             <div id="collapseTwo22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Menu Pengeluaran</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikan">Lap Perbaikan LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanP">Lap Perbaikan PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBr">Lap Perbaikan BTA</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
                 </div>
             </div>
         </li>
          <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
               15  aria-expanded="true" aria-controls="collapseTwo1">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >SDM</span>
             </a>
             <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
                 </div>
             </div>
         </li>
         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse22"
               15  aria-expanded="true" aria-controls="collapse22">
                 <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                 <span style="font-size: 15px; color:white;" >Pertashop</span>
             </a>
             <div id="collapse22" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header" style="font-size: 15px;">Pertashop</h6>
                     <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Pembelian</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan">Lap Penjualan</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPs">Laba Rugi</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualan">Grafik Penjualan</a>
                     <a class="collapse-item" style="font-size: 15px;" href="Setoran">Setoran</a>
                     <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
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
<?php  echo "<form  method='POST' action='VGrafikPenjualan'>" ?>
  <div>
    <div align="left" style="margin-left: 20px;"> 
      <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
      <span>-</span>
      <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
      <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
    </div>
  </div>
  <div class="col-md-8">
   <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
 </div>
 <br>
</form>
    <div id="chart_pendapatan_pertamax" >

    </div>
<br>
<hr>
<br>
    <div id="chart_pendapatan_dexlite" >

    </div>
    <br>
<hr>
<br>
    <div id="chart_penjualan_pertamax" >

    </div>
    <br>
<hr>
<br>
    <div id="chart_penjualan_dexlite" >

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
                <span aria-hidden="true"></span>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>  
Highcharts.chart('chart_pendapatan_pertamax', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pendapatan Pertamax'
    },
  
    xAxis: {
        categories: [
             <?php 
                
                foreach($data_tanggal as $a){
                 ?> ' <?php print_r($a);
             
                ?> ' <?php echo",";
                } ?> 
                     
                 
                 
                 
    
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pendapatan (Rp)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>Rp {point.y:.2f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Sumber Jaya',
        data: [<?php foreach($data_pendapatan_sj as $x){
            print_r($x);
            echo",";
       } ?>]

    }, {
        name: 'Bedilan',
        data: [<?php foreach($data_pendapatan_b as $x){
            print_r($x);
            echo",";
       } ?>]

    }, {
        name: 'Nusa Bakti',
        data: [<?php foreach($data_pendapatan_nb as $x){
            print_r($x);
            echo",";
       } ?>]

    }]
});
</script>

<script>  
Highcharts.chart('chart_pendapatan_dexlite', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Pendapatan Dexlite'
    },
  
    xAxis: {
        categories: [
             <?php 
                
                foreach($data_tanggal_dex as $a){
                 ?> ' <?php print_r($a);
             
                ?> ' <?php echo",";
                } ?> 
                     
                 
                 
                 
    
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pendapatan (Rp)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>Rp {point.y:.2f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
  
        name: 'Nusa Bakti',
        data: [<?php foreach($data_pendapatan_nb_dex as $x){
            print_r($x);
            echo",";
       } ?>]

    }]
});
</script>

<script>  
Highcharts.chart('chart_penjualan_pertamax', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Penjualan Pertamax'
    },
  
    xAxis: {
        categories: [
             <?php 
                
                foreach($data_tanggal as $a){
                 ?> ' <?php print_r($a);
             
                ?> ' <?php echo",";
                } ?> 
                     
                 
                 
                 
    
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Penjualan (L)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}/L</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Sumber Jaya',
        data: [<?php foreach($data_penjualan_sj as $x){
            print_r($x);
            echo",";
       } ?>]

    }, {
        name: 'Bedilan',
        data: [<?php foreach($data_penjualan_b as $x){
            print_r($x);
            echo",";
       } ?>]

    }, {
        name: 'Nusa Bakti',
        data: [<?php foreach($data_penjualan_nb as $x){
            print_r($x);
            echo",";
       } ?>]

    }]
});
</script>

<script>  
Highcharts.chart('chart_penjualan_dexlite', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Penjualan Dexlite'
    },
  
    xAxis: {
        categories: [
             <?php 
                
                foreach($data_tanggal_dex as $a){
                 ?> ' <?php print_r($a);
             
                ?> ' <?php echo",";
                } ?> 
                     
                 
                 
                 
    
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Pendapatan (Rp)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}/L</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
  
        name: 'Nusa Bakti',
        data: [<?php foreach($data_penjualan_nb_dex as $x){
            print_r($x);
            echo",";
       } ?>]

    }]
});
</script>

</body>

</html>