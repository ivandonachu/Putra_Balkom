<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION["login"])) {
  header("Location: logout.php");
  exit;
}
$id = $_COOKIE['id_cookie'];
$result1 = mysqli_query($koneksi, "SELECT * FROM account WHERE id_karyawan = '$id'");
$data1 = mysqli_fetch_array($result1);
$id1 = $data1['id_karyawan'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Administrasi') {
} else {
  header("Location: logout.php");
  exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
}
else{
    $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  }

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point WHERE tanggal = '$tanggal_awal'");

  $table2 = mysqli_query($koneksi, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point  WHERE tanggal = '$tanggal_awal'");
  $data2 = mysqli_fetch_array($table2);
  $total_tagihan = $data2['total_tagihan'];
  $total_jt = $data2['total_jt'];
  $total_rit = $data2['total_rit'];
} else {
  $table = mysqli_query($koneksi, "SELECT * FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY a.tanggal");

  $table2 = mysqli_query($koneksi, "SELECT SUM(total) AS total_tagihan, SUM(jt) AS total_jt, SUM(rit) AS total_rit  FROM tagihan_ub a INNER JOIN master_tarif_ub b ON a.delivery_point=b.delivery_point WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
  $data2 = mysqli_fetch_array($table2);
  $total_tagihan = $data2['total_tagihan'];
  $total_jt = $data2['total_jt'];
  $total_rit = $data2['total_rit'];
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

  <title>Tagihan Angkutan Pertashop Ujung Berem</title>

  <!-- Custom fonts for this template-->
  <link href="/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsAdministrasi">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png" ></div>
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
        <i class="fas fa-file-invoice-dollar" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Tagihan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Tagihan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanTG">Tagihan Tanjung Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPA">Tagihan Padalarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanPL">Tagihan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanUB">Tagihan Ujung Berung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTagihanBA">Tagihan Balongan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifTG">Master Tarif TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPA">Master Tarif PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifPL">Master Tarif PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifUB">Master Tarif UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBA">Master Tarif BA</a>
        </div>
    </div>
</li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      15  aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-truck" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Pengiriman</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Pengiriman</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanTG">Pengiriman TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPA">Pengiriman PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanPL">Pengiriman PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanUB">Pengiriman UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanBA">Pengiriman BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseTG">Ritase TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePA">Ritase PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitasePL">Ritase PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseUB">Ritase UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitaseBA">Ritase BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhTG">Jarak Tempuh TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPA">Jarak Tempuh PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhPL">Jarak Tempuh PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhUB">Jarak Tempuh UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBA">Jarak Tempuh BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiTG">Gaji TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPA">Gaji PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiPL">Gaji PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiUB">Gaji UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiBA">Gaji BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VGajiKaryawan">Gaji Karyawan</a>
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
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanTG">Catat Perbaikan TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPA">Catat Perbaikan PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanPL">Catat Perbaikan PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanUB">Catat Perbaikan UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBA">Catat Perbaikan BA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulTG">Pengeluaran Pul TG</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPA">Pengeluaran Pul PA</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulPL">Pengeluaran Pul PL</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulUB">Pengeluaran Pul UB</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBA">Pengeluaran Pul BA</a>
        </div>
    </div>
</li>
 <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
      15  aria-expanded="true" aria-controls="collapseTwo1">
        <i class="fas fa-car" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >SDM</span>
    </a>
    <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VAMT">AMT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
            <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
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
        <?php $foto_profile = $data1['foto_profile']; ?>
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


            <?php echo "<form  method='POST' action='VTagihanUB' style='margin-bottom: 15px;'>" ?>
            <div>
              <div align="left" style="margin-left: 20px;">
                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                <span>-</span>
                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
              </div>
            </div>
            </form>

            <div class="row">
              <div class="col-md-6">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>
              <div class="col-md-6">
                <!-- Button Input Data Bayar -->
                <div align="right">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Tagihan </button> <br> <br>
                </div>

                <!-- Form Modal  -->
                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> Form Tagihan </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <!-- Form Input Data -->
                      <div class="modal-body" align="left">
                        <?php echo "<form action='../proses/proses_tagihan_UB?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                        <div class="row">
                          <div class="col-md-6">

                            <label>Tanggal</label>
                            <div class="col-sm-10">
                              <input type="date" id="tanggal" name="tanggal" required="">
                            </div>


                          </div>

                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <label>SO</label>
                            <input class="form-control form-control-sm" type="text" id="so" name="so" required="">
                          </div>



                          <div class="col-md-6">
                            <label>LO</label>
                            <input class="form-control form-control-sm" type="text" id="lo" name="lo" required="">
                          </div>

                        </div>


                        <br>

                        <div class="row">

                          <div class="col-md-6">
                            <label>Delivery Point</label>
                            <select id="tokens" class="selectpicker form-control" name="delivery_point" multiple data-live-search="true">
                              <?php
                              include 'koneksi.php';
                              $result2 = mysqli_query($koneksi, "SELECT * FROM master_tarif_ub");

                              while ($data2 = mysqli_fetch_array($result2)) {
                                $data_tarif = $data2['delivery_point'];

                      
                                  echo "<option> $data_tarif </option> ";
                                
                              }
                              ?>
                            </select>
                            <small>pilih satu saja jangan doubel</small>
                          </div>


                          <div class="col-md-6">
                            <label>Jumlah Pemesanan</label>
                            <select id="jumlah_pesanan" name="jumlah_pesanan" class="form-control">
                              <option>1000 L</option>
                              <option>2000 L</option>
                              <option>3000 L</option>
                              <option>4000 L</option>
                              <option>5000 L</option>
                            </select>
                          </div>

                        </div>

                        <br>

                        <div class="row">

                          <div class="col-md-6">
                            <label>AMT</label>
                            <select id="amt" name="amt" class="form-control ">
                              <?php
                              include 'koneksi.php';
                              $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Tanjung Gerem'");

                              while ($data2 = mysqli_fetch_array($result)) {
                                $nama_driver = $data2['nama_driver'];


                                echo "<option> $nama_driver </option> ";
                              }
                              ?>
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label>MT</label>
                            <select id="mt" name="mt" class="form-control">
                              <?php
                              include 'koneksi.php';
                              $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Tanjung Gerem'");

                              while ($data2 = mysqli_fetch_array($result)) {
                                $no_polisi = $data2['no_polisi'];


                                echo "<option> $no_polisi </option> ";
                              }
                              ?>
                            </select>
                          </div>

                        </div>

                        <br>

                        <div>
                          <label>Upload File</label>
                          <input type="file" name="file">
                        </div>


                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary"> BAYAR</button>
                          <button type="reset" class="btn btn-danger"> RESET</button>
                        </div>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <!-- Tabel -->
            <div style="overflow-x: auto" align = 'center';>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>SO</th>
                  <th>LO</th>
                  <th>Delivery Point</th>
                  <th>Alamat</th>
                  <th>Jumlah Pemesanan</th>
                  <th>Jarak Tempuh</th>
                  <th>AMT</th>
                  <th>MT</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th>File</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_max_pesanan = 0;
                $urut = 0;
                function formatuang($angka)
                {
                  $uang = "Rp " . number_format($angka, 2, ',', '.');
                  return $uang;
                }

                ?>

                <?php while ($data = mysqli_fetch_array($table)) {
                  $no_tagihan = $data['no_tagihan'];
                  $tanggal = $data['tanggal'];
                  $so = $data['so'];
                  $lo = $data['lo'];
                  $supply_point = $data['supply_point'];
                  $alamat = $data['alamat'];
                  $delivery_point = $data['delivery_point'];
                  $jumlah_pesanan = $data['jumlah_pesanan'];
                  $jt = $data['jt'];
                  $amt = $data['amt'];
                  $mt = $data['mt'];
                  $total = $data['total'];
                  $file_bukti = $data['file_bukti'];
                  if ($jumlah_pesanan == 'kl1') {
                    $total_pesanan = 1000;
                    $total_max_pesanan = $total_max_pesanan + $total_pesanan;
                  } else if ($jumlah_pesanan == 'kl2') {
                    $total_pesanan = 2000;
                    $total_max_pesanan = $total_max_pesanan + $total_pesanan;
                  } else if ($jumlah_pesanan == 'kl3') {
                    $total_pesanan = 3000;
                    $total_max_pesanan = $total_max_pesanan + $total_pesanan;
                  } else if ($jumlah_pesanan == 'kl4') {
                    $total_pesanan = 4000;
                    $total_max_pesanan = $total_max_pesanan + $total_pesanan;
                  } else if ($jumlah_pesanan == 'kl5') {
                    $total_pesanan = 5000;
                    $total_max_pesanan = $total_max_pesanan + $total_pesanan;
                  }
                  $harga1 = $data[$jumlah_pesanan];
                    if($jumlah_pesanan == 'kl1'){
                        $harga = $harga1 / 1000;
                    }
                    else if($jumlah_pesanan == 'kl2'){
                        $harga = $harga1 / 2000;
                    }
                    else if($jumlah_pesanan == 'kl3'){
                        $harga = $harga1 / 3000;
                    }
                    else if($jumlah_pesanan == 'kl4'){
                      $harga = $harga1 / 4000;
                    }

                    else if($jumlah_pesanan == 'kl5'){
                      $harga = $harga1 / 5000;
                    }

      


                  $urut = $urut + 1;

                  echo "<tr>
      <td style='font-size: 14px'>$urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$so</td>
      <td style='font-size: 14px'>$lo</td>
      <td style='font-size: 14px'>$delivery_point</td>
      <td style='font-size: 14px'>$alamat</td>
      <td style='font-size: 14px'>$total_pesanan/L</td>
      <td style='font-size: 14px'>$jt</td>
      <td style='font-size: 14px'>$amt</td>
      <td style='font-size: 14px'>$mt</td>
      <td style='font-size: 14px'>"; ?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($total); ?> <?php echo "</td>
      <td style='font-size: 14px'>"; ?> <a download="../file_administrasi/<?= $file_bukti ?>" href="../file_administrasi/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
                    <?php echo "<td style='font-size: 12px'>"; ?>
                    <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_tagihan']; ?>">Edit</button>

                    <!-- Form EDIT DATA -->

                    <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_tagihan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title"> Form Edit Tagihan </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                              <span aria-hidden="true"> &times; </span>
                            </button>
                          </div>

                          <!-- Form Edit Data -->
                          <div class="modal-body" align="left">
                            <form action="../proses/edit_tagihan_UB" enctype="multipart/form-data" method="POST">

                              <input type="hidden" name="no_tagihan" value="<?php echo $no_tagihan; ?>">
                              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                              <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">

                              <div class="row">
                                <div class="col-md-6">

                                  <label>Tanggal</label>
                                  <div class="col-sm-10">
                                    <input type="date" id="tanggal" name="tanggal" required="" disabled="" value="<?php echo $tanggal; ?>">
                                  </div>

                                </div>

                              </div>

                              <div class="row">


                                <div class="col-md-6">
                                  <label>SO</label>
                                  <input class="form-control form-control-sm" type="text" id="so" name="so" required="" value="<?php echo $so; ?>">
                                </div>



                                <div class="col-md-6">
                                  <label>LO</label>
                                  <input class="form-control form-control-sm" type="text" id="lo" name="lo" required="" value="<?php echo $lo; ?>">
                                </div>

                              </div>



                              <br>
                              <label>Delivery Point</label>
                              <div class="row">

                                <div class="col-md-6">

                                  <select id="tokens" class="selectpicker form-control" name="delivery_point" multiple data-live-search="true">
                                    <?php
                                    include 'koneksi.php';
                                    $dataSelect = $data['delivery_point'];
                                    $result = mysqli_query($koneksi, "SELECT * FROM master_tarif_ub");

                                    while ($data2 = mysqli_fetch_array($result)) {
                                      $data_tarif = $data2['delivery_point'];


                                      echo "<option" ?> <?php echo ($dataSelect == $data_tarif) ? "selected" : "" ?>> <?php echo $data_tarif; ?> <?php echo "</option>";
                                                                                                                                                  }
                                                                                                                                                    ?>
                                  </select>

                                </div>


                                <div class="col-md-6">
                                  <label>Jumlah Pemesanan</label>
                                  <select id="jumlah_pesanan" name="jumlah_pesanan" class="form-control">
                                    <?php
                                    $dataSelect = $data['jumlah_pesanan']; ?>
                                    <option <?php echo ($dataSelect == 'kl1') ? "selected" : "" ?>>1000 L</option>
                                    <option <?php echo ($dataSelect == 'kl2') ? "selected" : "" ?>>2000 L</option>
                                    <option <?php echo ($dataSelect == 'kl3') ? "selected" : "" ?>>3000 L</option>
                                    <option <?php echo ($dataSelect == 'kl4') ? "selected" : "" ?>>4000 L</option>
                                    <option <?php echo ($dataSelect == 'kl5') ? "selected" : "" ?>>5000 L</option>
                                  </select>
                                </div>

                              </div>

                              <br>

                              <div class="row">

                                <div class="col-md-6">
                                  <label>AMT</label>

                                  <select id="amt" name="amt" class="form-control ">
                                    <?php
                                    $dataSelect = $data['amt'];
                                    include 'koneksi.php';
                                    $result = mysqli_query($koneksi, "SELECT * FROM driver WHERE alamat = 'Tanjung Gerem'");

                                    while ($data2 = mysqli_fetch_array($result)) {
                                      $nama_driver = $data2['nama_driver'];

                                      echo "<option" ?> <?php echo ($dataSelect == $nama_driver) ? "selected" : "" ?>> <?php echo $nama_driver; ?> <?php echo "</option>";
                                                                                                                                                    }
                                                                                                                                                      ?>
                                  </select>


                                </div>

                                <div class="col-md-6">
                                  <label>MT</label>
                                  <select id="mt" name="mt" class="form-control">
                                    <?php
                                    $dataSelect = $data['mt'];
                                    include 'koneksi.php';
                                    $result = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi = 'Tanjung Gerem'");

                                    while ($data2 = mysqli_fetch_array($result)) {
                                      $no_polisi = $data2['no_polisi'];

                                      echo "<option" ?> <?php echo ($dataSelect == $no_polisi) ? "selected" : "" ?>> <?php echo $no_polisi; ?> <?php echo "</option>";
                                                                                                                                                }
                                                                                                                                                  ?>
                                  </select>
                                </div>
                              </div>

                              <br>

                              <div>
                                <label>Upload File</label>
                                <input type="file" name="file">
                              </div>
                          </div>


                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Ubah </button>
                            <button type="reset" class="btn btn-danger"> RESET</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
          


          <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_tagihan']; ?>" data-toggle='tooltip' title='Hapus Transaksi'></button>

          <div class="modal fade" id="PopUpHapus<?php echo $data['no_tagihan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"> <b> Hapus </b> </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                  </button>
                </div>

                <div class="modal-body">
                  <form action="../proses/hapus_tagihan_UB" method="POST">
                    <input type="hidden" name="no_tagihan" value="<?php echo $data['no_tagihan']; ?>">
                    <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                    <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">

                    <div class="form-group">
                      <h6> Yakin Ingin Hapus Data? </h6>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary"> Hapus </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php echo  " </td> </tr>";
                }
        ?>

        </tbody>
        </table>
        </div>
          </div>
        <br>
        <div class="row" style="margin-right: 20px; margin-left: 20px;">
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Tagihan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_tagihan)  ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Ritase</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_rit  ?></div>
                  </div>
                  <div class="col-auto">
                    <i class=" fas fa-truck-moving fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total KM</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_jt  ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-road fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Total Pesanan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_max_pesanan ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
      var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>
  <script>
    function createOptions(number) {
      var options = [],
        _options;

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

    $('#special').on('click', function() {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function() {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });
  </script>
</body>

</html>