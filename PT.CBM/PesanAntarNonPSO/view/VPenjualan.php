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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'CS Pesan Antar Non PSO') {
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
} else {
  $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksi, "SELECT * FROM penjualan_pesan_antar_non_pso WHERE tanggal = '$tanggal_akhir' ");
} else {
  $table = mysqli_query($koneksi, "SELECT * FROM penjualan_pesan_antar_non_pso WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal ASC");
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

  <title>Penjualan Non PSO</title>

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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsPesanAntar">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;" src="../gambar/Logo CBM.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="DsPesanAntar">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;">Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading" style="font-size: 15px; color:white;">
        Menu Pesan Antar Non PSO
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Transaksi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Transaksi</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualanPangkalan">Penjualan Pangkalan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapRekeningNonPso">Rekening Non PSO</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLStok">Laporan Stok</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLStokGudang">Stok Gudang BK3</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLStokRantauPanjang">Stok Rantau Panjang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSetoranNPSO">Setoran NPSO</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSetoranPSO">Setoran PSO</a>
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
          <?php echo "<a href='VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Penjualan Pesan Antar Non PSO</h5></a>"; ?>

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline  small" style="color:white;"><?php echo "$nama"; ?></span>
                <img class="img-profile rounded-circle" src="/assets/img/foto_profile/<?= $foto_profile; ?>"><!-- link foto profile -->
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
          <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;" align='center'>


            <?php echo "<form  method='POST' action='VPenjualan' style='margin-bottom: 15px;'>" ?>
            <div>
              <div align="left" style="margin-left: 20px;">
                <input type="date" id="tanggal1" style="font-size: 14px" name="tanggal1">
                <span>-</span>
                <input type="date" id="tanggal2" style="font-size: 14px" name="tanggal2">
                <button type="submit" name="submmit" style="font-size: 12px; margin-left: 10px; margin-bottom: 2px;" class="btn1 btn btn-outline-primary btn-sm">Lihat</button>
              </div>
            </div>
            </form>

            <br>
            <br>
            <div class="row">
              <div class="col-md-6">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>
              <div class="col-md-6">
                <!-- Button Input Data Bayar -->
                <div align="right">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Penjualan </button> <br> <br>
                </div>

                <!-- Form Modal  -->
                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> Form Penjualan </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <!-- Form Input Data -->
                      <div class="modal-body" align="left">
                        <?php echo "<form action='../proses/proses_penjualan_pesan_antar?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Tanggal</label>
                            <div class="col-sm-10">
                              <input type="date" name="tanggal" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label>Area</label>
                            <select name="area" class="form-control">
                              <option></option>
                              <option>BK 3</option>
                              <option>Gumawang</option>
                              <option>Rantau Panjang</option>
                              <option>Muara Dua</option>
                              <option>Pangkalan CBM</option>
                            </select>
                          </div>
                        </div>

                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Nama Pembeli</label>
                            <div class="col-sm-12">
                              <input class="form-control form-control-sm" type="text" name="nama_pembeli" required="">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label>Alamat Pembeli</label>
                            <div class="col-sm-12">
                              <input class="form-control form-control-sm" type="text" name="alamat_pembeli" required="">
                            </div>
                          </div>
                        </div>


                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>QTY Bright Gas 12 KG</label>
                            <input class="form-control form-control-sm" type="float" id="qty_12kg" name="qty_12kg" required="">
                          </div>

                          <div class="col-md-6">
                            <label>Harga Bright Gas 12 KG</label>
                            <input class="form-control form-control-sm" type="number" id="harga_12kg" name="harga_12kg" required="">
                          </div>
                        </div>

                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>QTY Bright Gas 5,5 KG</label>
                            <input class="form-control form-control-sm" type="float" id="qty_55kg" name="qty_55kg" required="">
                          </div>

                          <div class="col-md-6">
                            <label>Harga Bright Gas 5,5 KG</label>
                            <input class="form-control form-control-sm" type="number" id="harga_55kg" name="harga_55kg" required="">
                          </div>
                        </div>

                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Ongkos Kirim</label>
                            <input class="form-control form-control-sm" type="number" id="ongkos_kirim" name="ongkos_kirim" required="">
                          </div>
                          <div class="col-md-6">
                            <label>Tipe Pembayaran</label>
                            <select id="tipe_pembayaran" name="tipe_pembayaran" class="form-control">
                              <option>Tunai</option>
                              <option>Transfer</option>
                              <option>QRIS</option>
                            </select>
                          </div>
                        </div>

                        <br>

                        <div>
                          <label>Keterangan</label>
                          <div class="form-group">
                            <textarea id="keterangan" name="keterangan" style="width: 300px;"></textarea>
                          </div>

                          <br>
                          <div>
                            <label>Upload File</label>
                            <input type="file" name="file">
                          </div>


                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> OKE </button>
                            <button type="reset" class="btn btn-danger"> BATAL </button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <!-- Tabel -->
            <div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Area</th>
                    <th>Nama Pembeli</th>
                    <th>Alamat Pembeli</th>
                    <th>QTY BG 12 KG</th>
                    <th>Harga BG 12 KG</th>
                    <th>Jumlah BG 12 KG</th>
                    <th>QTY BG 55 KG</th>
                    <th>Harga BG 55 KG</th>
                    <th>Jumlah BG 55 KG</th>
                    <th>Ongkos Kirim</th>
                    <th>Tipe Pembayaran</th>
                    <th>Ket</th>
                    <th>File</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no_urut = 0;
                  $total_penjualan_12kg = 0;
                  $total_uang_12kg = 0;
                  $total_penjualan_55kg = 0;
                  $total_uang_55kg = 0;
                  $total_ongkos_kirim = 0;

                  $total_penjualan_12kg_tf = 0;
                  $total_uang_12kg_tf = 0;
                  $total_penjualan_55kg_tf = 0;
                  $total_uang_55kg_tf = 0;
                  $total_ongkos_kirim_tf = 0;

                  $total_penjualan_12kg_q = 0;
                  $total_uang_12kg_q = 0;
                  $total_penjualan_55kg_q = 0;
                  $total_uang_55kg_q = 0;
                  $total_ongkos_kirim_q = 0;

                  function formatuang($angka)
                  {
                    $uang = "Rp " . number_format($angka, 2, ',', '.');
                    return $uang;
                  }

                  ?>

                  <?php while ($data = mysqli_fetch_array($table)) {
                    $no_transaksi = $data['no_transaksi'];
                    $tanggal = $data['tanggal'];
                    $area = $data['area'];
                    $nama_pembeli = $data['nama_pembeli'];
                    $alamat_pembeli = $data['alamat_pembeli'];
                    $qty_12kg = $data['qty_12kg'];
                    $harga_12kg = $data['harga_12kg'];
                    $jumlah_12kg = $data['jumlah_12kg'];
                    $qty_55kg = $data['qty_55kg'];
                    $harga_55kg = $data['harga_55kg'];
                    $jumlah_55kg = $data['jumlah_55kg'];
                    $ongkos_kirim = $data['ongkos_kirim'];
                    $tipe_pembayaran = $data['tipe_pembayaran'];
                    if ($tipe_pembayaran == 'Tunai') {
                      $total_penjualan_12kg = $total_penjualan_12kg + $qty_12kg;
                      $total_uang_12kg = $total_uang_12kg + $jumlah_12kg;
                      $total_penjualan_55kg = $total_penjualan_55kg + $qty_55kg;
                      $total_uang_55kg = $total_uang_55kg + $jumlah_55kg;
                      $total_ongkos_kirim = $total_ongkos_kirim + $ongkos_kirim;
                    } else if ($tipe_pembayaran == 'Transfer') {
                      $total_penjualan_12kg_tf = $total_penjualan_12kg_tf + $qty_12kg;
                      $total_uang_12kg_tf = $total_uang_12kg_tf + $jumlah_12kg;
                      $total_penjualan_55kg_tf = $total_penjualan_55kg_tf + $qty_55kg;
                      $total_uang_55kg_tf = $total_uang_55kg_tf + $jumlah_55kg;
                      $total_ongkos_kirim_tf = $total_ongkos_kirim_tf + $ongkos_kirim;
                    } else if ($tipe_pembayaran == 'QRIS') {
                      $total_penjualan_12kg_q = $total_penjualan_12kg_q + $qty_12kg;
                      $total_uang_12kg_q = $total_uang_12kg_q + $jumlah_12kg;
                      $total_penjualan_55kg_q = $total_penjualan_55kg_q + $qty_55kg;
                      $total_uang_55kg_q = $total_uang_55kg_q + $jumlah_55kg;
                      $total_ongkos_kirim_q = $total_ongkos_kirim_q + $ongkos_kirim;
                    }


                    $keterangan = $data['keterangan'];
                    $file_bukti = $data['file_bukti'];
                    $no_urut = $no_urut + 1;
                    echo "<tr>
                     <td style='font-size: 14px'>$no_urut</td> 
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$area</td>
      <td style='font-size: 14px'>$nama_pembeli</td>
      <td style='font-size: 14px'>$alamat_pembeli</td>
      <td style='font-size: 14px'>$qty_12kg</td>
      <td style='font-size: 14px'>"; ?> <?= formatuang($harga_12kg); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($jumlah_12kg); ?> <?php echo "</td>
      <td style='font-size: 14px'>$qty_55kg</td>
      <td style='font-size: 14px'>"; ?> <?= formatuang($harga_55kg); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($jumlah_55kg); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($ongkos_kirim); ?> <?php echo "</td>
      <td style='font-size: 14px'>$tipe_pembayaran</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="" href="/PT.CBM/PesanAntarNonPSO/file_pesan_antar/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>"
                      <?php echo "<td style='font-size: 12px'>"; ?>
                      <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_transaksi']; ?>">Edit</button>

                      <!-- Form EDIT DATA -->

                      <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Form Edit Penjualan </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true"> &times; </span>
                              </button>
                            </div>

                            <!-- Form Edit Data -->
                            <div class="modal-body" align="left">
                              <form action="../proses/edit_penjualan_pesan_antar" enctype="multipart/form-data" method="POST">

                                <input type="hidden" name="no_transaksi" value="<?php echo $no_transaksi; ?>">
                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">


                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Tanggal</label>
                                    <div class="col-sm-10">
                                      <input type="date" name="tanggal" value="<?php echo $tanggal; ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <label>Area</label>
                                    <select id="area" name="area" class="form-control">
                                      <?php $dataSelect = $data['area']; ?>
                                      <option <?php echo ($dataSelect == 'BK 3') ? "selected" : "" ?>>BK 3</option>
                                      <option <?php echo ($dataSelect == 'Gumawang') ? "selected" : "" ?>>Gumawang</option>
                                      <option <?php echo ($dataSelect == 'Rantau Panjang') ? "selected" : "" ?>>Rantau Panjang</option>
                                      <option <?php echo ($dataSelect == 'Muara Dua') ? "selected" : "" ?>>Muara Dua</option>
                                      <option <?php echo ($dataSelect == 'Pangkalan CBM') ? "selected" : "" ?>>Pangkalan CBM</option>
                                    </select>
                                  </div>
                                </div>

                                <br>

                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Nama Pembeli</label>
                                    <div class="col-sm-12">
                                      <input class="form-control form-control-sm" type="text" name="nama_pembeli" required="" value="<?php echo $nama_pembeli; ?>">
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <label>Alamat Pembeli</label>
                                    <div class="col-sm-12">
                                      <input class="form-control form-control-sm" type="text" name="alamat_pembeli" required="" value="<?php echo $alamat_pembeli; ?>">
                                    </div>
                                  </div>
                                </div>

                                <br>

                                <br>

                                <div class="row">
                                  <div class="col-md-6">
                                    <label>QTY Bright Gas 12 KG</label>
                                    <input class="form-control form-control-sm" type="float" id="qty_12kg" name="qty_12kg" required="" value="<?php echo $qty_12kg; ?>">
                                  </div>

                                  <div class="col-md-6">
                                    <label>Harga Bright Gas 12 KG</label>
                                    <input class="form-control form-control-sm" type="number" id="harga_12kg" name="harga_12kg" required="" value="<?php echo $harga_12kg; ?>">
                                  </div>
                                </div>

                                <br>

                                <div class="row">
                                  <div class="col-md-6">
                                    <label>QTY Bright Gas 5,5 KG</label>
                                    <input class="form-control form-control-sm" type="float" id="qty_55kg" name="qty_55kg" required="" value="<?php echo $qty_55kg; ?>">
                                  </div>

                                  <div class="col-md-6">
                                    <label>Harga Bright Gas 5,5 KG</label>
                                    <input class="form-control form-control-sm" type="number" id="harga_55kg" name="harga_55kg" required="" value="<?php echo $harga_55kg; ?>">
                                  </div>
                                </div>

                                <br>

                                <br>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Ongkos Kirim</label>
                                    <input class="form-control form-control-sm" type="number" id="ongkos_kirim" name="ongkos_kirim" required="" value="<?php echo $ongkos_kirim; ?>">
                                  </div>
                                  <div class="col-md-6">
                                    <label>Tipe Pembayaran</label>
                                    <select id="tipe_pembayaran" name="tipe_pembayaran" class="form-control">
                                      <?php $dataSelect = $data['tipe_pembayaran']; ?>
                                      <option <?php echo ($dataSelect == 'Tunai') ? "selected" : "" ?>>Tunai</option>
                                      <option <?php echo ($dataSelect == 'Transfer') ? "selected" : "" ?>>Transfer</option>
                                      <option <?php echo ($dataSelect == 'QRIS') ? "selected" : "" ?>>QRIS</option>
                                    </select>
                                  </div>
                                </div>

                                <br>

                                <div>
                                  <label>Keterangan</label>
                                  <div class="form-group">
                                    <textarea id="keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan; ?></textarea>
                                  </div>
                                </div>

                                <br>

                                <div>
                                  <label>Upload File</label>
                                  <input type="file" name="file">
                                </div>


                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary"> UBAH </button>
                                  <button type="reset" class="btn btn-danger"> BATAL </button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php echo "</td>"; ?>
                      <?php echo "<td style='font-size: 12px'>"; ?>
                      <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_transaksi']; ?>" data-toggle='tooltip' title='Hapus Transaksi'>Hapus</button>

                      <div class="modal fade" id="PopUpHapus<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"> <b> Hapus </b> </h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true"> &times; </span>
                              </button>
                            </div>

                            <div class="modal-body">
                              <form action="../proses/hapus_penjualan_pesan_antar" method="POST">
                                <input type="hidden" name="no_transaksi" value="<?php echo $data['no_transaksi']; ?>">
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
                    <?php echo " </td>
                </tr>";
                  }
                    ?>

                </tbody>
              </table>
            </div>
            <br>
            <div class="row" style="margin-right: 20px; margin-left: 20px;">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Penjualan Bright Gas 12 KG Tunai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_12kg ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 12 KG Tunai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_12kg) ?></div>
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
                          Total Penjualan Bright Gas 5,5 KG Tunai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_55kg  ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 5,5 KG Tunai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_55kg) ?></div>
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
            <br>

            <div class="row" style="margin-right: 20px; margin-left: 20px;">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Penjualan Bright Gas 12 KG Transfer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_12kg_tf ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 12 KG Transfer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_12kg_tf) ?></div>
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
                          Total Penjualan Bright Gas 5,5 KG Transfer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_55kg_tf  ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 5,5 KG Transfer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_55kg_tf) ?></div>
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
            <br>

            <div class="row" style="margin-right: 20px; margin-left: 20px;">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Penjualan Bright Gas 12 KG QRIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_12kg_q ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 12 KG QRIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_12kg_q) ?></div>
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
                          Total Penjualan Bright Gas 5,5 KG QRIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penjualan_55kg_q  ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
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
                          Total Uang Bright Gas 5,5 KG QRIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_uang_55kg_q) ?></div>
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
            <br>

            <div class="row" style="margin-right: 20px; margin-left: 20px;">
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Ongkos Kirim Cash</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_ongkos_kirim) ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Ongkos Kirim Transfer</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_ongkos_kirim_tf) ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Total Ongkos Kirim QRIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_ongkos_kirim_q) ?></div>
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
  <script>
    function sum() {
      var banyak_barang = document.getElementById('qty').value;
      var harga = document.getElementById('harga').value;
      var result = parseFloat(banyak_barang) * parseFloat(harga);
      if (!isNaN(result)) {
        document.getElementById('jumlah').value = result;
      }
    }
  </script>
</body>

</html>