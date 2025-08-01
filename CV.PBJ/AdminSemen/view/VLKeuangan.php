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
if ($jabatan_valid == 'Admin Semen') {
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
  $table = mysqli_query($koneksi, "SELECT * FROM keuangan_sl WHERE tanggal = '$tanggal_awal'");

  $table2 = mysqli_query($koneksi, "SELECT nama_akun,  SUM(jumlah) AS total_jumlah FROM keuangan_sl  WHERE tanggal = '$tanggal_awal' GROUP BY nama_akun");
} else {
  $table = mysqli_query($koneksi, "SELECT * FROM keuangan_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC");

  $table2 = mysqli_query($koneksi, "SELECT nama_akun,  SUM(jumlah) AS total_jumlah FROM keuangan_sl  WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY nama_akun");
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

  <title>Keuangan</title>

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

  <!-- Link datepicker -->

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav  sidebar sidebar-dark accordion" style=" background-color: #004445" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasir">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3"> <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG"></div>
      </a>
      <br>

      <br>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="DsAdminSemen">
          <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
          <span style="font-size: 16px;">Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading" style="font-size: 15px; color:white;">
        ADMIN SEMEN
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 15 aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-cash-register" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">Kasir</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPiutang">Piutang Semen</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengeluaran">Pengeluaran</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualanL">Rekap DO Penjualan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPembelian">Rekap DO Pembelian</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPotonganHarga">Potongan Harga</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
            <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Uang Sewa Hi Blow</a>
            <a class="collapse-item" style="font-size: 15px;" href="VFilePBJ">File PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VStokGudang">Stok Gudang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapTagihan">Rekap Tagihan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VRekapPiutang">Rekap Piutang</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" 15 aria-expanded="true" aria-controls="collapseTwo1">
          <i class="fas fa-truck-moving" style="font-size: 15px; color:white;"></i>
          <span style="font-size: 15px; color:white;">SDM</span>
        </a>
        <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
            <a class="collapse-item" style="font-size: 15px;" href="VDriverSemen">List Driver</a>
            <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
            <a class="collapse-item" style="font-size: 15px;" href="VListKota">List Kota</a>
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
          <?php echo "<a href='VLSaldo'><h5 class='text-center sm' style='color:white; margin-top: 8px; '>Pencatatan Keuangan</h5></a>"; ?>
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
          <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

            <?php echo "<form  method='POST' action='VLKeuangan' style='margin-bottom: 15px;'>" ?>
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
              <div class="col-md-8">
                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
              </div>
            </div>

            <div class="row">
              <div class="col-md-10">

              </div>
              <div class="col-md-2">
                <!-- Button Pindah Baja -->
                <div align="right">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Keuangan </button> <br> <br>
                </div>
                <!-- Form Modal  -->
                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> Form Pencatatan Keuangan </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <!-- Form Input Data -->
                      <div class="modal-body" align="left">
                        <?php echo "<form action='../proses/proses_keuangan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                        <div class="row">
                          <div class="col-md-6">

                            <label>Tanggal</label>
                            <div class="col-sm-10">
                              <input type="date" id="tanggal" name="tanggal" required="">
                            </div>


                          </div>
                          <div class="col-md-6">
                            <label>Rekening</label>
                            <select name="rekening" class="form-control">
                              <option>BRI Harian</option>
                              <option>BRI DF</option>
                              <option>Mandiri</option>
                              <option>BNI</option>
                            </select>
                          </div>
                        </div>
                        <br>

                        <div class="row">
                          <div class="col-md-6">
                            <label>Akun</label>
                            <select id="nama_akun" name="nama_akun" class="form-control">
                              <option>Bayar Piutang</option>
                              <option>Karyawan Bon</option>
                              <option>Setor Uang</option>
                              <option>Bayar Sewa Kendaraan Luar</option>
                              <option>Pendapatan Sewa</option>
                              <option>Ongkos Kuli</option>
                              <option>Uang Jalan</option>
                              <option>Biaya Konsumsi</option>
                              <option>Biaya Administrasi</option>
                              <option>Biaya Kantor</option>
                              <option>Transport / Perjalanan Dinas</option>
                              <option>Listrik & Telepon</option>
                              <option>Alat Tulis Kantor</option>
                              <option>Perbaikan Kendaraan</option>
                              <option>Pembelian Sparepart</option>
                              <option>Gaji Karyawan</option>
                              <option>Kembalikan Deposit</option>
                              <option>Pengeluaran Lainnya</option>
                              <option>Pemasukan Lainnya</option>
                              <option>Bayar BPJS</option>
                              <option>Biaya Pajak</option>
                              <option>Pembelian Barang Jual</option>
                              <option>Pinjam Saldo</option>
                              <option>Pindah Saldo</option>
                              <option>Kembalikan Saldo</option>
                              <option>Bunga Bank</option>
                              <option>Oprasional Pabrik</option>
                              <option>Pengeluaran Khusus</option>
                              <option>Pengeluaran PT BBE</option>
                              <option>Pengeluaran PT MJRE</option>
                              <option>Pengeluaran PT Gel Gel</option>
                              <option>Pengeluaran PT Sawit Dalam</option>
                              <option>Kebun Seberuk</option>
                              <option>Kebun Lengkiti</option>
                              <option>Kebun Mesuji</option>
                              <option>Pembelian Aset</option>
                              <option>Pembangunan Aset</option>
                              <option>Pengeluaran Pribadi</option>
                              <option>Sumbangan</option>
                              <option>Kredit Kendaraan</option>
                              <option>Pengeluaran CV PBJ</option>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <label>Jumlah</label>
                            <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah" value='0' required="">
                          </div>
                        </div>


                        <br>

                        <div>
                          <label>Keterangan</label>
                          <div class="form-group">
                            <textarea id="keterangan" name="keterangan" style="width: 300px;"></textarea>
                          </div>
                        </div>

                        <div>
                          <label>Upload File</label>
                          <input type="file" name="file">
                        </div>

                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">CATAT</button>
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
            <div style="overflow-x: auto" align='center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Rekening</th>
                    <th>Akun</th>
                    <th></th>
                    <th>Keterangan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Saldo</th>
                    <th>file</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $total_kredit = 0;
                  $no_urut = 0;
                  $total_debit = 0;
                  function formatuang($angka)
                  {
                    $uang = "Rp " . number_format($angka, 2, ',', '.');
                    return $uang;
                  }

                  ?>
                  <?php while ($data = mysqli_fetch_array($table)) {
                    $no_laporan = $data['no_transaksi'];
                    $tanggal = $data['tanggal'];
                    $rekening = $data['rekening'];
                    $nama_akun = $data['nama_akun'];
                    $status_saldo = $data['status_saldo'];
                    $jumlah = $data['jumlah'];
                    $keterangan = $data['keterangan'];
                    if ($status_saldo == 'Masuk') {
                      $total_debit = $total_debit + $jumlah;
                    } elseif ($status_saldo == 'Keluar') {
                      $total_kredit = $total_kredit + $jumlah;
                    }
                    $no_urut = $no_urut + 1;
                    $file_bukti = $data['file_bukti'];
                    echo "<tr>
      <td style='font-size: 14px'>$no_urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$rekening</td>
      <td style='font-size: 14px'>$nama_akun</td>
      "; ?>
                    <?php echo "<td style='font-size: 12px'>"; ?>

                    <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_transaksi']; ?>">Edit</button>

                    <!-- Form EDIT DATA -->

                    <div class="modal fade" id="formedit<?php echo $data['no_transaksi']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title"> Form Edit </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                              <span aria-hidden="true"> &times; </span>
                            </button>
                          </div>


                          <!-- Form Edit Data -->
                          <div class="modal-body">
                            <form action="../proses/edit_keuangan" method="POST" enctype="multipart/form-data">



                              <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                              <input type="hidden" name="no_transaksi" value="<?php echo $no_laporan; ?>">
                              <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                              <div class="row">
                                <div class="col-md-6">

                                  <label>Tanggal</label>
                                  <div class="col-sm-10">
                                    <input type="date" id="tanggal" name="tanggal" required="" value="<?php echo $tanggal; ?>">
                                  </div>


                                </div>
                                <div class="col-md-6">
                                <label>Rekening</label>
                                  <select  name="rekening" class="form-control">
                                    <?php $dataSelect = $data['rekening']; ?>
                                    <option <?php echo ($dataSelect == 'BRI Harian') ? "selected" : "" ?>>BRI Harian</option>
                                    <option <?php echo ($dataSelect == 'BRI DF') ? "selected" : "" ?>>BRI DF</option>
                                    <option <?php echo ($dataSelect == 'Mandri') ? "selected" : "" ?>>Mandri</option>
                                    <option <?php echo ($dataSelect == 'BNI') ? "selected" : "" ?>>BNI</option>
                                  </select>

                                </div>
                              </div>
                              <br>



                              <div class="row">
                                <div class="col-md-6">
                                  <label>Akun</label>
                                  <select id="nama_akun" name="nama_akun" class="form-control">
                                    <?php $dataSelect = $data['nama_akun']; ?>
                                    <option <?php echo ($dataSelect == 'Bayar Piutang') ? "selected" : "" ?>>Bayar Piutang</option>
                                    <option <?php echo ($dataSelect == 'Karyawan Bon') ? "selected" : "" ?>>Karyawan Bon</option>
                                    <option <?php echo ($dataSelect == 'Setor Uang') ? "selected" : "" ?>>Setor Uang</option>
                                    <option <?php echo ($dataSelect == 'Bayar Sewa Kendaraan Luar') ? "selected" : "" ?>>Bayar Sewa Kendaraan Luar</option>
                                    <option <?php echo ($dataSelect == 'Pendapatan Sewa') ? "selected" : "" ?>>Pendapatan Sewa</option>
                                    <option <?php echo ($dataSelect == 'Ongkos Kuli') ? "selected" : "" ?>>Ongkos Kuli</option>
                                    <option <?php echo ($dataSelect == 'Uang Jalan') ? "selected" : "" ?>>Uang Jalan</option>
                                    <option <?php echo ($dataSelect == 'Biaya Konsumsi') ? "selected" : "" ?>>Biaya Konsumsi</option>
                                    <option <?php echo ($dataSelect == 'Biaya Administrasi') ? "selected" : "" ?>>Biaya Administrasi</option>
                                    <option <?php echo ($dataSelect == 'Biaya Kantor') ? "selected" : "" ?>>Biaya Kantor</option>
                                    <option <?php echo ($dataSelect == 'Transport / Perjalanan Dinas') ? "selected" : "" ?>>Transport / Perjalanan Dinas</option>
                                    <option <?php echo ($dataSelect == 'Listrik & Telepon') ? "selected" : "" ?>>Listrik & Telepon</option>
                                    <option <?php echo ($dataSelect == 'Alat Tulis Kantor') ? "selected" : "" ?>>Alat Tulis Kantor</option>
                                    <option <?php echo ($dataSelect == 'Perbaikan Kendaraan') ? "selected" : "" ?>>Perbaikan Kendaraan</option>
                                    <option <?php echo ($dataSelect == 'Pembelian Sparepart') ? "selected" : "" ?>>Pembelian Sparepart</option>
                                    <option <?php echo ($dataSelect == 'Gaji Karyawan') ? "selected" : "" ?>>Gaji Karyawan</option>
                                    <option <?php echo ($dataSelect == 'Kembalikan Deposit') ? "selected" : "" ?>>Kembalikan Deposit</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran Lainnya') ? "selected" : "" ?>>Pengeluaran Lainnya</option>
                                    <option <?php echo ($dataSelect == 'Pemasukan Lainnya') ? "selected" : "" ?>>Pemasukan Lainnya</option>
                                    <option <?php echo ($dataSelect == 'Bayar BPJS') ? "selected" : "" ?>>Bayar BPJS</option>
                                    <option <?php echo ($dataSelect == 'Biaya Pajak') ? "selected" : "" ?>>Biaya Pajak</option>
                                    <option <?php echo ($dataSelect == 'Pembelian Barang Jual') ? "selected" : "" ?>>Pembelian Barang Jual</option>
                                    <option <?php echo ($dataSelect == 'Pinjam Saldo') ? "selected" : "" ?>>Pinjam Saldo</option>
                                    <option <?php echo ($dataSelect == 'Pindah Saldo') ? "selected" : "" ?>>Pindah Saldo</option>
                                    <option <?php echo ($dataSelect == 'Kembalikan Saldo') ? "selected" : "" ?>>Kembalikan Saldo</option>
                                    <option <?php echo ($dataSelect == 'Kembalikan Saldo') ? "selected" : "" ?>>Oprasional Pabrik</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran Khusus') ? "selected" : "" ?>>Pengeluaran Khusus</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran PT BBE') ? "selected" : "" ?>>Pengeluaran PT BBE</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran PT MJRE') ? "selected" : "" ?>>Pengeluaran PT MJRE</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran PT Gel Gel') ? "selected" : "" ?>>Pengeluaran PT Gel Gel</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran PT Sawit Dalam') ? "selected" : "" ?>>Pengeluaran PT Sawit Dalam</option>
                                    <option <?php echo ($dataSelect == 'Kebun Seberuk') ? "selected" : "" ?>>Kebun Seberuk</option>
                                    <option <?php echo ($dataSelect == 'Kebun Lengkiti') ? "selected" : "" ?>>Kebun Lengkiti</option>
                                    <option <?php echo ($dataSelect == 'Kebun Mesuji') ? "selected" : "" ?>>Kebun Mesuji</option>
                                    <option <?php echo ($dataSelect == 'Pembelian Aset') ? "selected" : "" ?>>Pembelian Aset</option>
                                    <option <?php echo ($dataSelect == 'Pembangunan Aset') ? "selected" : "" ?>>Pembangunan Aset</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran Pribadi') ? "selected" : "" ?>>Pengeluaran Pribadi</option>
                                    <option <?php echo ($dataSelect == 'Sumbangan') ? "selected" : "" ?>>Sumbangan</option>
                                    <option <?php echo ($dataSelect == 'Kredit Kendaraan') ? "selected" : "" ?>>Kredit Kendaraan</option>
                                    <option <?php echo ($dataSelect == 'Pengeluaran CV PBJ') ? "selected" : "" ?>>Pengeluaran CV PBJ</option>
                                  </select>
                                </div>
                                <div class="col-md-6">
                                  <label>Jumlah</label>
                                  <input class="form-control form-control-sm" type="number" id="jumlah" name="jumlah" value='<?php echo $jumlah; ?>' required="">
                                </div>
                              </div>


                              <br>

                              <div>
                                <label>Keterangan</label>
                                <div class="form-group">
                                  <textarea id="keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan; ?></textarea>
                                </div>
                              </div>
                              <div>
                                <label>Upload File</label>
                                <input type="file" name="file">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> Ubah </button>
                                <button type="reset" class="btn btn-danger"> RESET</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>



                    <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_transaksi']; ?>" data-toggle='tooltip' title='Hapus Pencatatan'>Hapus</button>

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
                            <form action="../proses/hapus_keuangan" method="POST">
                              <input type="hidden" name="no_transaksi" value="<?php echo $no_laporan; ?>">
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

                    <?php echo  " </td>"; ?> <?php echo "
      <td style='font-size: 14px'>$keterangan</td>";


                                              if ($status_saldo == 'Masuk') {
                                                echo "
        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                    } else {
                                                                      echo "
        <td style='font-size: 14px'>" ?> <?php echo "</td>";
                                                                    }

                                                                    if ($status_saldo == 'Keluar') {
                                                                      echo "
        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>";
                                                                    } else {
                                                                      echo "
        <td style='font-size: 14px'>" ?> <?php echo "</td>";
                                                                    }
                                          ?>
                    <?php echo "
      <td style='font-size: 14px'>" ?> <?= formatuang($total_debit - $total_kredit); ?> <?php echo "   </td>
      <td style='font-size: 14px'>"; ?> <a download="../file_admin_semen/<?= $file_bukti ?>" href="../file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
    " ?>
                    <?php echo  "</tr>";
                  }

                    ?>

                </tbody>
              </table>
            </div>
            <br>
            <br>
            <br>
            <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">

              <!-- Tabel -->
              <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
                <thead>
                  <tr>
                    <th>Total Debit</th>
                    <th>Total Kredit</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  echo "<tr>
      <td style='font-size: 14px'>"; ?> <?= formatuang($total_debit); ?> <?php echo "</td>
      <td style='font-size: 14px'>"; ?> <?= formatuang($total_kredit); ?> <?php echo "</td>
      </tr>";

                                                                          ?>

                </tbody>
              </table>
            </div>
            <br>
            <br>
            <br>
            <hr>
            <br>

            <h5 align="center">Rincian Pengeluaran</h5>
            <!-- Tabel -->
            <table class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%; ">
              <thead>
                <tr>
                  <th>Akun</th>
                  <th>Total Pengeluaran</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sisa_saldo = 0;
                $total_pengeluaran = 0;
                $total_saldo = 0;
                ?>
                <?php while ($data = mysqli_fetch_array($table2)) {
                  $nama_akun = $data['nama_akun'];
                  $jumlah = $data['total_jumlah'];

                  if ($nama_akun == 'Bayar Piutang' || $nama_akun == 'Pendapatan Sewa') {
                    $sisa_saldo  = $sisa_saldo + $jumlah;
                    $total_saldo = $total_saldo + $jumlah;
                  } else if ($nama_akun == 'Setor Uang' || $nama_akun == 'Kembalikan Deposit' || $nama_akun == 'Pembelian Barang Jual'  || $nama_akun == 'Kembalikan Saldo') {
                  } else {
                    $sisa_saldo  = $sisa_saldo - $jumlah;
                    $total_pengeluaran = $total_pengeluaran + $jumlah;
                  }



                  echo "<tr>

       <td style='font-size: 14px' >$nama_akun</td>
        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
      
     

  </tr>";
                                                                  }
                                                                    ?> <tr>
                  <td style='font-size: 14px; '><strong>Total Sakdo</strong></td>
                  <td style='font-size: 14px'> <strong> <?= formatuang($total_saldo); ?></strong> </td>
                </tr>
                <tr>
                  <td style='font-size: 14px; '><strong>Total Pengeluaran</strong></td>
                  <td style='font-size: 14px'> <strong> <?= formatuang($total_pengeluaran); ?></strong> </td>
                </tr>
                <tr>
                  <td style='font-size: 14px; '><strong>Sisa Saldo</strong></td>
                  <td style='font-size: 14px'> <strong> <?= formatuang($sisa_saldo); ?></strong> </td>
                </tr>




                </tr>
              </tbody>
            </table>

            <br>
            <hr>
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
      var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
    });
  </script>



</body>

</html>