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
$nama_pemilik = $data1['nama_pemilik'];

if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
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

  <title>Profile</title>

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/css/styleprofil.css" rel="stylesheet">

  <script type="text/javascript">
    window.setTimeout("waktu()", 1000);

    function waktu() {
      var tanggal = new Date();
      setTimeout("waktu()", 1000);
      document.getElementById("jam").innerHTML = tanggal.getHours();
      document.getElementById("menit").innerHTML = tanggal.getMinutes();
      document.getElementById("detik").innerHTML = tanggal.getSeconds();
    }
  </script>

</head>

<style>
  #jam-digital {
    overflow: hidden
  }

  #hours {
    float: left;
    width: 50px;
    height: 30px;
    background-color: #2C7873;
    margin-right: 25px
  }

  #minute {
    float: left;
    width: 50px;
    height: 30px;
    background-color: #2C7873;
    margin-right: 25px
  }

  #second {
    float: left;
    width: 50px;
    height: 30px;
    background-color: #2C7873;
  }

  #jam-digital p {
    color: #FFF;
    font-size: 22px;
    text-align: center
  }
</style>

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
                <a class="collapse-item" style="font-size: 15px;" href="../VPenjualan">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengiriman">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VKeuangan">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluran">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranWorkshop">Pengeluaran Workshop</a>
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
                
                <a class="collapse-item" style="font-size: 15px;" href="../VPenjualanL">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPenebusanL">Laporan Penebusan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengirimanL">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VKeuanganL">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VPengeluaranL">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VRekapDoPenjualanL">Rekap DO Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="../VRekapDoPembelian">Rekap DO Pembelian</a>
            </div>
        </div>
    </li>

    <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='../VLR2L'> Laba Rugi </a>
                          </li>";
                        } ?>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='../VLR2LBaru'> Laba Rugi Baru </a>
                          </li>";
                        } ?>
                        <?php if($nama == 'Nyoman Edy Susanto'){
                          echo"
                          <li class='nav-item'>
                          <i class='fas fa-chart-line' style='font-size: 15px; color:white; margin-left: 15px; margin-top: 15px; margin-bottom: 15px;' ></i> 
                          <a style='font-size: 15px; color:white; margin-left: 4px; text-decoration: none; ' href='../VRekapanHarga'> Rekapan Harga</a>
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
        <div class="row">
          <div class="col-sm-9">
          </div>
          <div class="col-sm-3" style="color: black; font-size: 18px;">
            <script type='text/javascript'>
              var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
              var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
              var date = new Date();
              var day = date.getDate();
              var month = date.getMonth();
              var thisDay = date.getDay(),
                thisDay = myDays[thisDay];
              var yy = date.getYear();
              var year = (yy < 1000) ? yy + 1900 : yy;
              document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
            </script>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-9">
          </div>
          <div class="col-sm-3">
            <div id="jam-digital">
              <div id="hours">
                <p id="jam"></p>
              </div>
              <div id="minute">
                <p id="menit"> </p>
              </div>
              <div id="second">
                <p id="detik"> </p>
              </div>
            </div>
          </div>
        </div>
        <div class="container light-style flex-grow-1 container-p-y">

          <h4 class="font-weight-bold py-3 mb-4">
            Account settings
          </h4>

          
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="account-general">
                    <?php echo "<form action='edit_profil' enctype='multipart/form-data' method='POST'>";  ?>
                    <div class="card-body media align-items-center">
                    <img src="/assets/img/foto_profile/<?= $foto_profile; ?>" style="max-height: 150px; " alt="" class="d-block ui-w-80">
                      <div class="media-body ml-4">


                        <input type="file" class="" name='file_profile'>
                        <input type="hidden" name="nama_pemilik" value="<?= $nama_pemilik; ?>">

                      </div>
                    </div>
                    <hr class="border-light m-0">
                    <div class="card-body">
                      <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control mb-1" name="nama_karyawan" value="<?= $nama; ?> "disabled>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" value="<?= $jabatan_valid; ?> " disabled>
                      
                      </div>
           
                    
                    </div>
                  </div>


                    <div class="tab-pane fade" id="account-change-password">
                    <div class="card-body pb-2">
                      <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control mb-1" disabled>
                      </div>
                      <div class="form-group">
                        <label class="form-label">password lama</label>
                        <input type="password" name="password_lama" class="form-control" disabled>
                      </div>

                      <div class="form-group">
                        <label class="form-label">password baru</label>
                        <input type="password" name="password_baru1" class="form-control" disabled>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Konfirmasi password baru</label>
                        <input type="password" name="password_baru2" class="form-control" disabled>
                      </div>
                      <small>
                        <ul>
                          <li>password tidak boleh ada spasi</li>
                          <li>minimal password 8 character</li>
                          <li>maksimal password 15 character</li>
                        </ul>
                      </small>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="text-right mt-3">
            <button type="Submit" class="btn btn-primary">Save changes</button>&nbsp;
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
          </form>
        </div>
        <br>

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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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