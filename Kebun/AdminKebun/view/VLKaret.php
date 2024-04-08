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
if ($jabatan_valid == 'Admin Kebun') {
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
    $table = mysqli_query($koneksi, "SELECT * FROM laporan_karet WHERE tanggal = '$tanggal_akhir' ");
} else {
    $table = mysqli_query($koneksi, "SELECT * FROM laporan_karet WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal ASC");
    $table2 = mysqli_query($koneksi, "SELECT SUM(box_karet) AS total_box, SUM(berat) AS total_berat, SUM(upah_bersih) AS total_upah_bersih  FROM laporan_karet WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    $data2 = mysqli_fetch_array($table2);
    $total_box = $data2['total_box'];
    $total_berat = $data2['total_berat'];
    $total_upah_bersih = $data2['total_upah_bersih'];

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

    <title>Laporan Karet</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKebun">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3"> <img style="height: 55px; width: 190px;"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="DsKebun">
                    <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
                    <span style="font-size: 16px;">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

           <!-- Heading -->
           <div class="sidebar-heading" style="font-size: 15px; color:white;">
                     Menu Admin Kebun
                </div>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  15  aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >Laporan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu Laporan</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VLAbsensiL">Absensi Lengkiti</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKegiatan">Laporan Kegiatan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLKaret">Laporan Karet</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLSawit">Laporan Sawit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPengeluaran">Pengeluaran Kebun</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLMinyak">Stok Minyak</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VLPupuk">Stok Pupuk</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitDriver">Laporan Rit</a>
                    </div>
                </div>
            </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                  15  aria-expanded="true" aria-controls="collapseTwo1">
                    <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
                    <span style="font-size: 15px; color:white;" >SDM</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header" style="font-size: 15px;">Menu SDM</h6>
                        <a class="collapse-item" style="font-size: 15px;" href="VDriverS">Driver Sawit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMobilS">Mobil Sawit</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKaryawanK">Karyawan Karet</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKaryawanL">Karyawan Lengkiti</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VListAsetLengkiti">List Aset Lengkiti</a>
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
                    <?php echo "<a href='VLKaret?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Laporan Karet</h5></a>"; ?>

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
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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


                    <!-- Name Page -->
                    <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


                        <?php echo "<form  method='POST' action='VLKaret' style='margin-bottom: 15px;'>" ?>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#input"> <i class="fas fa-plus-square mr-2"></i> Catat Laporan </button> <br> <br>
                                </div>

                                <!-- Form Modal  -->
                                <div class="modal fade bd-example-modal-lg" id="input" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> Form Laporan Karet </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Form Input Data -->
                                            <div class="modal-body" align="left">
                                                <?php echo "<form action='../proses/proses_karet?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir' enctype='multipart/form-data' method='POST'>";  ?>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Tanggal</label>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="tanggal">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Nama Karywawan</label>
                                                        <select id="tokens" class="selectpicker form-control" name="nama_karyawan" multiple data-live-search="true">
                                                        <option></option>
                                                        <?php
                                                        include 'koneksi.php';
                                                        $result2 = mysqli_query($koneksi, "SELECT * FROM karyawan_karet");   

                                                        while ($data2 = mysqli_fetch_array($result2)){
                                                        $data_pangakalan = $data2['nama_karyawan'];

                                                       
                                                            echo "<option> $data_pangakalan </option> ";
                                                        
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Box</label>
                                                        <input class="form-control form-control-sm" type="number" id="box" name="box" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Berat</label>
                                                        <input class="form-control form-control-sm" type="number" id="berat" name="berat" onkeyup="sum();" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Harga Karet</label>
                                                        <input class="form-control form-control-sm" type="number" id="harga" name="harga" onkeyup="sum();" required="">
                                                    </div>
                                                </div>

                                                <br>
                                                <script>

                                                function sum() {
                                                var berat = document.getElementById('berat').value;
                                                var harga = document.getElementById('harga').value;
                                                var pembagi = document.getElementById('pembagi').value;
                                                var oa = document.getElementById('oa').value;
                                                var b_kompor = document.getElementById('b_kompor').value;
                                                var tank_alpha = document.getElementById('tank_alpha').value;
                                                var cashbon = document.getElementById('cashbon').value;
                                                var result = (parseInt(berat) * parseInt(harga))/parseFloat(pembagi);
                                                if (!isNaN(result)) {
                                                document.getElementById('upah_kotor').value = result;
                                                }
                                                var result2 = parseFloat(result) - (parseInt(oa) + parseInt(b_kompor) + parseInt(tank_alpha) + parseInt(cashbon));
                                                if (!isNaN(result2)) {
                                                document.getElementById('upah_bersih').value = result2;
                                                }
                                                }
                                                </script>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Pembagi</label>
                                                        <input class="form-control form-control-sm" type="float" id="pembagi" name="pembagi" onkeyup="sum();" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Upah Kotor</label>
                                                        <input class="form-control form-control-sm" type="float" id="upah_kotor" name="upah_kotor" required=""> 
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Ongkos Angkut</label>
                                                        <input class="form-control form-control-sm" type="number" id="oa" name="oa" onkeyup="sum();" required="">
                                                    </div>
                                                </div>

                                                <br>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Bayar Kompor</label>
                                                        <input class="form-control form-control-sm" type="number" id="b_kompor" name="b_kompor" onkeyup="sum();" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Bayar Tank Alpha</label>
                                                        <input class="form-control form-control-sm" type="number" id="tank_alpha" name="tank_alpha" onkeyup="sum();" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Cashbon</label>
                                                        <input class="form-control form-control-sm" type="float" id="cashbon" name="cashbon" onkeyup="sum();" required=""> 
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Upah Bersih</label>
                                                        <input class="form-control form-control-sm" type="float" id="upah_bersih" name="upah_bersih" required=""> 
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <div>
                                                    <textarea id="keterangan" name="keterangan" style="width: 300px;"></textarea>
                                                    </div>
                                                </div>

                                                <br>

                                                <div>
                                                    <label>Upload File</label>
                                                    <input type="file" name="file">
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"> Catat</button>
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
                    <div style="overflow-x: auto" align = 'center'>
                    <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>BOX</th>
                                <th>Berat</th>
                                <th>Harga Karet</th>
                                <th>Pembagi</th>
                                <th>Upah Kotor</th>
                                <th>Ongkos Angkut</th>
                                <th>Bayar Kompor</th>
                                <th>Tank Alpha</th>
                                <th>Cashbon</th>
                                <th>Upah Bersih</th>
                                <th>Ket</th>
                                <th>File</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_urut = 0;
                            function formatuang($angka)
                            {
                                $uang = "Rp " . number_format($angka, 2, ',', '.');
                                return $uang;
                            }

                            ?>

                            <?php while ($data = mysqli_fetch_array($table)) {
                                $no_laporan = $data['no_laporan'];
                                $tanggal = $data['tanggal'];
                                $nama_karyawan = $data['nama_karyawan'];
                                $box = $data['box_karet'];
                                $berat = $data['berat'];
                                $harga_karet = $data['harga_karet'];
                                $pembagi = $data['pembagi'];
                                $upah_kotor = $data['upah_kotor'];
                                $ongkos_angkut = $data['ongkos_angkut'];
                                $bayar_kompor = $data['bayar_kompor'];
                                $tank_alpha = $data['tank_alpha'];
                                $cashbon = $data['cashbon'];
                                $upah_bersih = $data['upah_bersih'];
                                $keterangan = $data['keterangan'];
                                $file_bukti = $data['file_bukti'];
                                $no_urut = $no_urut + 1;


                                echo "<tr>
                                <td style='font-size: 14px'>$no_urut</td>
                                <td style='font-size: 14px'>$tanggal</td>
                                <td style='font-size: 14px'>$nama_karyawan</td>
                                <td style='font-size: 14px'>$box</td>
                                <td style='font-size: 14px'>$berat /KG</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($harga_karet); ?> <?php echo "</td>
                                <td style='font-size: 14px'>$pembagi</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($upah_kotor); ?> <?php echo "</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($ongkos_angkut); ?> <?php echo "</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($bayar_kompor); ?> <?php echo "</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($tank_alpha); ?> <?php echo "</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($cashbon); ?> <?php echo "</td>
                                <td style='font-size: 14px'>"; ?> <?= formatuang($upah_bersih); ?> <?php echo "</td>
                                <td style='font-size: 14px'>$keterangan</td>
                                <td style='font-size: 14px'>"; ?> <a download="../file_kebun/<?= $file_bukti ?>" href="../file_kebun/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
                                "; ?>
                                <?php echo "<td style='font-size: 12px'>"; ?>
                                <button href="#" type="button" class="fas fa-edit bg-warning mr-2 rounded" data-toggle="modal" data-target="#formedit<?php echo $data['no_laporan']; ?>">Edit</button>

                                <!-- Form EDIT DATA -->

                                <div class="modal fade bd-example-modal-lg " id="formedit<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role ="document">
                                    <div class="modal-content"> 
                                    <div class="modal-header">
                                        <h5 class="modal-title"> Form Edit Laporan </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                        <span aria-hidden="true"> &times; </span>
                                        </button>
                                    </div>

                                    <!-- Form Edit Data -->
                                    <div class="modal-body">
                                        <form action="../proses/edit_lap_karet" enctype="multipart/form-data" method="POST">

                                        <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>"> 
                                        <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                        <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">    

                                        <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Tanggal</label>
                                                        <div class="col-sm-10">
                                                        <input type="date"  name="tanggal" value="<?php echo $tanggal;?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Nama Karywawan</label>
                                                        <div>
                                                        <select id="tokens" class="selectpicker form-control" name="nama_karyawan" multiple data-live-search="true">
                                                        <option></option>
                                                        <?php
                                                        include 'koneksi.php';
                                                        $result2 = mysqli_query($koneksi, "SELECT * FROM karyawan_karet");   
                                                        $dataSelect = $data['nama_karyawan'];
                                                        while ($data2 = mysqli_fetch_array($result2)){
                                                        $data_pangakalan = $data2['nama_karyawan'];

                                                       
                                                            echo "<option" ?> <?php echo ($dataSelect == $data_pangakalan) ? "selected" : "" ?>> <?php echo $data_pangakalan; ?> <?php echo "</option>" ;
                                                        
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Box</label>
                                                        <input class="form-control form-control-sm" type="number" id="box" name="box" value="<?php echo $box;?>"  required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Berat</label>
                                                        <input class="form-control form-control-sm" type="number" id="berat" name="berat"  onkeyup="sum();" value="<?php echo $berat;?>" required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Harga Karet</label>
                                                        <input class="form-control form-control-sm" type="number" id="harga" name="harga"   onkeyup="sum();" value="<?php echo $harga_karet?>"  required="">
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Pembagi</label>
                                                        <input class="form-control form-control-sm" type="float" id="pembagi" name="pembagi"  onkeyup="sum();" value="<?php echo $pembagi;?>"  required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Upah Kotor</label>
                                                        <input class="form-control form-control-sm" type="float" id="upah_kotor" name="upah_kotor" value="<?php echo $upah_kotor;?>"  required=""> 
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Ongkos Angkut</label>
                                                        <input class="form-control form-control-sm" type="number" id="oa" name="oa"  onkeyup="sum();" value="<?php echo $ongkos_angkut;?>"  required="">
                                                    </div>
                                                </div>

                                                <br>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Bayar Kompor</label>
                                                        <input class="form-control form-control-sm" type="number" id="b_kompor" name="b_kompor"   onkeyup="sum();" value="<?php echo $bayar_kompor;?>"  required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Tank Alpha</label>
                                                        <input class="form-control form-control-sm" type="number" id="tank_alpha" name="tank_alpha"   onkeyup="sum();" value="<?php echo $tank_alpha;?>"  required="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Cashbon</label>
                                                        <input class="form-control form-control-sm" type="float" id="cashbon" name="cashbon" onkeyup="sum();" value="<?php echo $cashbon;?>"  required=""> 
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <label>Upah Bersih</label>
                                                        <input class="form-control form-control-sm" type="float" id="upah_bersih" name="upah_bersih" value="<?php echo $upah_bersih;?>"  required=""> 
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea id = "keterangan" name="keterangan" style="width: 300px;"><?php echo $keterangan;?></textarea>
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

                                <!-- Button Hapus -->
                                <button href="#" type="submit" class="fas fa-trash-alt bg-danger mr-2 rounded" data-toggle="modal" data-target="#PopUpHapus<?php echo $data['no_laporan']; ?>" data-toggle='tooltip' title='Hapus Data Dokumen'>Hapus</button>
                                <div class="modal fade" id="PopUpHapus<?php echo $data['no_laporan']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog" role ="document">
                                <div class="modal-content"> 
                                <div class="modal-header">
                                <h4 class="modal-title"> <b> Hapus Data Laporan </b> </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true"> &times; </span>
                                </button>
                                </div>

                                <div class="modal-body">
                                <form action="../proses/hapus_lap_karet" method="POST">
                                <input type="hidden" name="no_laporan" value="<?php echo $no_laporan;?>">
                                <input type="hidden" name="tanggal1" value="<?php echo $tanggal_awal; ?>">
                                <input type="hidden" name="tanggal2" value="<?php echo $tanggal_akhir;?>">   
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
   
         <br>
<div class="row" style="margin-right: 20px; margin-left: 20px;"  align = 'center'>
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Box</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $total_box ?></div>
          </div>
          <div class="col-auto">
           <i class="  fa-2x text-gray-300"></i>
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
            Total Berat</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_berat ?></div>
          </div>
          <div class="col-auto">
            <i class="fa-2x text-gray-300"></i>
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
            Total Upah Bersih</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($total_upah_bersih)   ?></div>
          </div>
          <div class="col-auto">
           <i class="  fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

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
</body>

</html>