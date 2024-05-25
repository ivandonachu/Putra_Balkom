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
if ($jabatan_valid == 'Kasir Semen') {
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
    $tujuan_pengiriman = $_GET['tujuan_pengiriman'];
} elseif (isset($_POST['tanggal1'])) {
    $tanggal_awal = $_POST['tanggal1'];
    $tanggal_akhir = $_POST['tanggal2'];
    $tujuan_pengiriman = $_POST['tujuan_pengiriman'];
} else {
    $tanggal_awal = date('Y-m-1');
    $tanggal_akhir = date('Y-m-31');
}

if ($tanggal_awal == $tanggal_akhir) {
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan_s WHERE tanggal_kirim = '$tanggal_akhir' AND status_bayar = 'Nyicil' AND tujuan_pengiriman = '$tujuan_pengiriman'  OR  tanggal_kirim = '$tanggal_akhir' AND status_bayar = 'Bon' AND tujuan_pengiriman = '$tujuan_pengiriman' ");
} else {
    $table = mysqli_query($koneksi, "SELECT * FROM penjualan_s WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil'  AND tujuan_pengiriman = '$tujuan_pengiriman'  OR  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND tujuan_pengiriman = '$tujuan_pengiriman'  ORDER BY tanggal_kirim ASC");
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

    <title>Rincian Piutang Region 1</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKasirSemen">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3" > <img style="margin-top: 50px; height: 100px; width: 110px; " src="../gambar/Logo PBJ.PNG" ></div>
            </a>
            <br>
            
            <br>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="DsKasirSemen">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;" >Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     KASIR SEMEN
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Kasir</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Kasir</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPiutang">Piutang Semen</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKeuangan">Laporan Keuangan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapDoPenjualan">Rekap Do Penjualan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VFilePBJ">File PBJ</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapTagihan">Rekap Tagihan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapPiutang">Rekap Piutang</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                  15  aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-truck-moving" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Menu SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VKendaraan">Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriverSemen">List Driver</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTokoDO">List Toko DO</a>
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
                    <?php echo "<a href='VPenjualan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Rincian Piutang Region 1</h5></a>"; ?>

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


                    <div align="left">
                            <?php echo "<a href='VRekapPiutang?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><button type='button' class='btn btn-primary'>Kembali</button></a>"; ?>
                        </div>

                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo " <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
                            </div>
                        </div>


                        <h4 align = 'center'>Tabel Piutang <?= $tujuan_pengiriman ?></h4>

                        <!-- Tabel -->
                        <div style="overflow-x: auto">
                            <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Edit</th>
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
                                        <th>Total</th>
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
                                    $total = 0;
                                    function formatuang($angka)
                                    {
                                        $uang = "Rp " . number_format($angka, 2, ',', '.');
                                        return $uang;
                                    }

                                    ?>

                                    <?php while ($data = mysqli_fetch_array($table)) {
                                        $no_penjualan = $data['no_penjualan'];
                                        $tanggal_do = $data['tanggal_do'];
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
                                        $total = $total + $jumlah;

                                        echo "<tr>
                                        <td style='font-size: 14px'>$no_urut</td>"; ?>
                                        <?php echo "<td style='font-size: 12px'>"; ?>
                                        <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_penjualan']; ?>">Edit</button>
                    
                                        <!-- Form EDIT DATA -->
                    
                                        <div class="modal fade bd-example-modal-lg" id="formedit<?php echo $data['no_penjualan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
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
                                                <form action="../proses/edit_piutang_r1" enctype="multipart/form-data" method="POST">
                                                  <script>
                                                    function sum2() {
                                                      var banyak_barang2 = document.getElementById('qty2').value;
                                                      var harga2 = document.getElementById('harga2').value;
                                                      var result2 = parseInt(banyak_barang2) * parseInt(harga2);
                                                      if (!isNaN(result2)) {
                                                        document.getElementById('jumlah2').value = result2;
                                                      }
                                                    }
                                                  </script>
                                                  <input type="hidden" name="no_penjualan" value="<?php echo $no_penjualan; ?>">
                                                  <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                                  <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir; ?>">
                                                  <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                    
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>Tanggal DO</label>
                                                      <div class="col-sm-10">
                                                        <input type="date" name="tanggal_do" value="<?php echo $tanggal_do; ?>">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Tanggal Kirim</label>
                                                      <div class="col-sm-10">
                                                        <input type="date" name="tanggal_kirim" value="<?php echo $tanggal_kirim; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>NO Do</label>
                                                      <div class="col-sm-10">
                                                        <input class="form-control form-control-sm" type="text" id="no_do" name="no_do" value="<?php echo $no_do; ?>">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>No Polisi</label>
                                                      <div class="col-sm-10">
                                                        <input class="form-control form-control-sm" type="text" id="no_polisi" name="no_polisi" value="<?php echo $no_polisi; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>Tujuan Pengiriman</label>
                                                      <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="text" id="tujuan_pengiriman" name="tujuan_pengiriman" required="" value="<?php echo $tujuan_pengiriman; ?>">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Driver</label>
                                                      <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="text" id="driver" name="driver" required="" value="<?php echo $driver; ?>">
                                                      </div>
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>QTY</label>
                                                      <input class="form-control form-control-sm" type="number" id="qty2" name="qty" onkeyup="sum2();" required="" value="<?php echo $qty; ?>">
                    
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Satuan</label>
                                                      <select id="satuan" name="satuan" class="form-control">
                                                        <?php $dataSelect = $data['satuan']; ?>
                                                        <option <?php echo ($dataSelect == 'Zak') ? "selected" : "" ?>>Zak</option>
                                                        <option <?php echo ($dataSelect == 'Bag') ? "selected" : "" ?>>Bag</option>
                    
                                                      </select>
                                                    </div>
                                                  </div>
                    
                    
                    
                                                  <br>
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>Harga Beli</label>
                                                      <input class="form-control form-control-sm" type="number" name="harga_beli" required="" value="<?php echo $harga_beli; ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Harga Jual</label>
                                                      <input class="form-control form-control-sm" type="number" id="harga2" name="harga" onkeyup="sum2();" required="" value="<?php echo $harga; ?>">
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>Nama Toko di DO</label>
                                                      <input class="form-control form-control-sm" type="text" id="toko_do" name="toko_do" value="<?php echo $toko_do; ?>">
                                                    </div>
                    
                                                    <div class="col-md-6">
                                                      <label>Tempo</label>
                                                      <input class="form-control form-control-sm" type="text" id="tempo" name="tempo" value="<?php echo $tempo; ?>">
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                    
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <label>Tanggal Bayar</label>
                                                      <div class="col-sm-10">
                                                        <input type="date" name="tanggal_bayar" value="<?php echo $tanggal_bayar; ?>">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Status Bayar</label>
                                                      <select id="status_bayar" name="status_bayar" class="form-control">
                                                        <?php
                                                        $dataSelect = $data['status_bayar']; ?>
                                                        <option <?php echo ($dataSelect == 'Lunas Transfer') ? "selected" : "" ?>>Lunas Transfer</option>
                                                        <option <?php echo ($dataSelect == 'Lunas Cash') ? "selected" : "" ?>>Lunas Cash</option>
                                                        <option <?php echo ($dataSelect == 'Nyicil') ? "selected" : "" ?>>Nyicil</option>
                                                        <option <?php echo ($dataSelect == 'Bon') ? "selected" : "" ?>>Bon</option>
                                                      </select>
                    
                                                    </div>
                                                  </div>
                    
                                                  <br>
                    
                                                  <div>
                                                    <label>Keterangan</label>
                                                    <div class="form-group">
                                                      <textarea id="keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan; ?></textarea>
                                                    </div>
                    
                    
                                                    <br>
                                                    <label>Catatan</label>
                                                    <div class="form-group">
                                                      <textarea id="catatan" name="catatan" style="width: 300px;"><?php echo $catatan; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <label>Bulan</label>
                                                      <input class="form-control form-control-sm" type="text" id="bulan" name="bulan" value="<?php echo $bulan; ?>">
                                                    </div>
                    
                                                    <br>
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
                    
                                        <?php echo "</td>
                                        <td style='font-size: 14px'>$tanggal_do</td>
                                        <td style='font-size: 14px'>$tanggal_kirim</td>
                                        <td style='font-size: 14px'>$no_do</td>
                                        <td style='font-size: 14px'>$driver</td>
                                        <td style='font-size: 14px'>$no_polisi</td>
                                        <td style='font-size: 14px'>$tujuan_pengiriman</td>
                                        <td style='font-size: 14px'>$satuan</td>
                                        <td style='font-size: 14px'>$qty</td>
                                        <td style='font-size: 14px'>"; ?> <?= formatuang($harga_beli); ?> <?php echo "</td>
                                        <td style='font-size: 14px'>"; ?> <?= formatuang($harga); ?> <?php echo "</td>
                                        <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
                                        <td style='font-size: 14px'>" ?> <?= formatuang($total); ?> <?php echo "</td>
                                        <td style='font-size: 14px'>$toko_do</td>
                                        <td style='font-size: 14px'>$tanggal_bayar</td>
                                        <td style='font-size: 14px'>$status_bayar</td>
                                        <td style='font-size: 14px'>$keterangan</td>
                                        <td style='font-size: 14px'>$catatan</td>
                                        <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/KasirSemen/file_semen/<?= $file_bukti ?>" href="/CV.PBJ/KasirSemen/file_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                        "; ?>




                                        <?php echo  " </tr>";
                                    }
                                        ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
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