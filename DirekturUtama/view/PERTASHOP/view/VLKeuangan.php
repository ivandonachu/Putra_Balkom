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

else{  header("Location: logout.php");
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
$pendapatan = 0;

if ($tanggal_awal == $tanggal_akhir) {
    
// TOTAL P[ENDAPATAN
$table = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal = '$tanggal_awal' AND b.lokasi = '$lokasi'  ");
while($data = mysqli_fetch_array($table)){
    $qty = $data['qty'];
    $harga = $data['harga'];
    $jumlah = $qty * $harga;
    $pendapatan = $pendapatan + $jumlah;
}


$table2 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta  WHERE tanggal = '$tanggal_awal' AND a.status_saldo = 'Keluar' AND b.lokasi = '$lokasi' ");
$data_pengeluaran = mysqli_fetch_array($table2);
$data_total_pengeluaran = $data_pengeluaran['total_pengeluaran'];
if (!isset($data_total_pengeluaran)) {
    $data_total_pengeluaran = 0;
}



$jumlah_bersih = $pendapatan - $data_total_pengeluaran;

}
else{

// TOTAL P[ENDAPATAN
$table = mysqli_query($koneksiperta, "SELECT qty , harga FROM penjualan a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND b.lokasi = '$lokasi'  ");
while($data = mysqli_fetch_array($table)){
    $qty = $data['qty'];
    $harga = $data['harga'];
    $jumlah = $qty * $harga;
    $pendapatan = $pendapatan + $jumlah;
}


$table2 = mysqli_query($koneksiperta, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran a INNER JOIN pertashop b ON b.kode_perta=a.kode_perta WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
 AND a.status_saldo = 'Keluar' AND b.lokasi = '$lokasi' ");
$data_pengeluaran = mysqli_fetch_array($table2);
$data_total_pengeluaran = $data_pengeluaran['total_pengeluaran'];
if (!isset($data_total_pengeluaran)) {
    $data_total_pengeluaran = 0;
}



$jumlah_bersih = $pendapatan - $data_total_pengeluaran;

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

  <title>Laporan Keuangan Pertashop</title>

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
                        <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPs">Laba Rugi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="Setoran">Setoran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualan">Lap Penjualan Pertamax</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPenjualanDex">Lap Penjualan Dexlite</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCorPertamax">Lap Ngecor Pertamax</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCorDexlite">Lap Ngecor Dexlite</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaran">Laporan Pengeluran</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPembelian">Laporan Pembelian</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VAbsensi">Absensi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualan">Grafik Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGrafikPenjualanPagi">Grafik Jual Pagi</a>
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
<div class="container" style="color : black;">
     <?php  echo "<form  method='POST' action='VLKeuangan' style='margin-bottom: 15px;'>" ?>
    <div>
      <div align="left" style="margin-left: 20px;"> 
        <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1"> 
        <span>-</span>
        <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
        <select id="lokasi" name="lokasi"s>
            <?php
            include 'koneksi.php';
            $result = mysqli_query($koneksiperta, "SELECT * FROM pertashop");   

            while ($data2 = mysqli_fetch_array($result)){
              $nama_driver = $data2['lokasi'];


              echo "<option> $nama_driver </option> ";
              
            }
            ?>
          </select>
        <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm" >Lihat</button>
      </div>
    </div>
  </form>

 <br>
 <br>
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
     <br>
     <br>
     <br>
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title" align="Center"><strong>Laporan Keuangan <?php echo $lokasi ?></strong></h3>
    			</div>

    			<div>
    				
    			</div>
                <?php
                function formatuang($angka){
                 $uang = "Rp " . number_format($angka,2,',','.');
                 return $uang;
                 }

                ?>


    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed"  style="color : black;">
    						<thead>
                                <tr>
        							<td><strong>Akun</strong></td>
        							<td class="text-center"><strong>Jumlah</strong></td>
        							<td class="text-right"><strong>Aksi</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>Total Pendapatan</td>
    								<td class="text-center"><?php echo formatuang($pendapatan);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPendapatan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
    							</tr>
                                <tr>
        							<td>Total Pengeluaran</td>
    								<td class="text-center"><?php echo formatuang($data_total_pengeluaran);  ?></td>
    								<?php echo "<td class='text-right'><a href='VRincianPengeluaran?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir&lokasi=$lokasi'>Rincian</a></td>"; ?>
    							</tr>
    						
    							<tr>
    								<td><strong>Total</strong></td>
    								<td class="no-line text-center"><?php echo formatuang($jumlah_bersih); ?></td>
    								<td class="thick-line"></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <br>
<br>

<!-- Tanda Konfirmasi  -->
 
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