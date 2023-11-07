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
$foto_profile = $data1['foto_profile'];
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Administrasi') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Administrasi</title>

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
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihan">Tagihan Lampung</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanL8">Tagihan Lampung 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanP">Tagihan Pelembang</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanBr">Tagihan Baturaja</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanBl">Tagihan Belitung</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VTagihanBk">Tagihan Bangka</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarif">Master Tarif LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifL8">Master Tarif LMG 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifP">Master Tarif PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBr">Master Tarif BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBl">Master Tarif BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VMasterTarifBk">Master Tarif BK</a>
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
                        <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL8">Pengiriman LMG 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaP">Pengiriman PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBr">Pengiriman BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBl">Pengiriman BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengirimanaBk">Pengiriman BK</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitase">Ritase LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseL8">Ritase LMG 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseP">Ritase PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseBr">Ritase BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseBl">Ritase BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRitaseBk">Ritase BK</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuh">Jarak Tempuh LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhL8">Jarak Tempuh LMG 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhP">Jarak Tempuh PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBr">Jarak Tempuh BTA</a> 
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBl">Jarak Tempuh BL</a> 
                        <a class="collapse-item" style="font-size: 15px;" href="VJarakTempuhBk">Jarak Tempuh BK</a> 
                        <a class="collapse-item" style="font-size: 15px;" href="VGaji">Gaji LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiL8">Gaji LMG 8KL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiP">Gaji PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiBr">Gaji BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiBl">Gaji BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VGajiBk">Gaji BK</a>
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
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikan">Catat Perbaikan LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanP">Catat Perbaikan PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBr">Catat Perbaikan BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBl">Catat Perbaikan BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VCatatPerbaikanBk">Catat Perbaikan BK</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPul">Pengeluaran Pul LMG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulP">Pengeluaran Pul PLG</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBr">Pengeluaran Pul BTA</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBl">Pengeluaran Pul BL</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranPulBk">Pengeluaran Pul BK</a>
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
                        <a class="collapse-item" style="font-size: 15px;" href="VMT">MT</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VBayarKredit">Kredit Kendaraan</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VKreditKenPribadi">Kredit Ken Pribadi</a>
                        <a class="collapse-item" style="font-size: 15px;" href="VRekapBBM">Rekap BBM</a>
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
                <div id="hours"><p id="jam"></p> </div> 
                <div id="minute"><p id="menit"> </p></div>
                <div id="second"><p id="detik"> </p></div>
            </div>
        </div>
    </div>

    <div class="container">
    <?php 
    $table = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE wilayah_operasi != 'Keluar'  ORDER BY wilayah_operasi ");
    $no_urut = 0;
    ?>
    
    <div style="overflow-x: auto" align = 'center';>
    <h3 align = 'center'>Region SUMBAGSEL & JAWA</h3>
 <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
      <th>No Polisi</th>
      <th>Jenis Kendaraan</th>
      <th>Wilayah Operasi</th>
      <th>File STNK</th>
      <th>Tanggal STNK</th>
      <th>File Tera Tangki</th>
      <th>Tanggal Tera Tangki</th>
      <th>File Tera FlowMeter</th>
      <th>Tanggal Tera FlowMeter</th>
      <th>File KIR</th>
      <th>Tanggal KIR</th>
    </tr>
  </thead>
  <tbody>

    <?php while($data = mysqli_fetch_array($table)){
     $no_urut = $no_urut+1;
     $no_polisi = $data['no_polisi'];
     $jenis_kendaraan =$data['jenis_kendaraan'];
     $wilayah_operasi =$data['wilayah_operasi'];
     $file_stnk = $data['file_stnk'];
     $tanggal_stnk = $data['tanggal_stnk'];
     $file_tera_tangki = $data['file_tera_tangki'];
     $tanggal_tera_tangki = $data['tanggal_tera_tangki'];
     $file_tera_flowmeter = $data['file_tera_flowmeter'];
     $tanggal_tera_flowmeter = $data['tanggal_tera_flowmeter'];
     $file_kir = $data['file_kir'];
     $tanggal_kir = $data['tanggal_kir'];

     $bulan_acuanx = date('m');
     $bulan_acuan = ltrim($bulan_acuanx, '0');
     $bulan_acuan = $bulan_acuan + 1;
     if($bulan_acuan == 13){
        $bulan_acuan = $bulan_acuan + 1;
        $tahun_acuan = $tahun_acuan + 1;
     }
     $tahun_acuan = date('Y');


     $bulan_stnkx = date('m', strtotime($tanggal_stnk)); 
     $bulan_stnk = ltrim($bulan_stnkx, '0');



     $tahun_stnk = date('Y', strtotime($tanggal_stnk)); 


     $bulan_tera_tangkix = date('m', strtotime($tanggal_tera_tangki)); 
     $bulan_tera_tangki = ltrim($bulan_tera_tangkix, '0');

     $tahun_tera_tangki = date('Y', strtotime($tanggal_tera_tangki)); 


     $bulan_flowmeterx = date('m', strtotime($tanggal_tera_flowmeter)); 
     $bulan_flowmeter = ltrim($bulan_flowmeterx , '0');

     $tahun_flowmeter = date('Y', strtotime($tanggal_tera_flowmeter)); 


     $bulan_kirx = date('m', strtotime($tanggal_kir)); 
     $bulan_kir = ltrim($bulan_kirx , '0');

     $tahun_kir = date('Y', strtotime($tanggal_kir)); 


     echo " <tr>
            <td style='font-size: 14px' align = 'center'>$no_urut</td>
            <td style='font-size: 14px' align = 'center'>$no_polisi </td>     
            <td style='font-size: 14px' align = 'center'>$jenis_kendaraan</td>
            <td style='font-size: 14px' align = 'center'>$wilayah_operasi</td>
            <td style='font-size: 14px'>"; ?> <a download="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_stnk ?>" href="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_stnk ?>"> <?php echo "$file_stnk </a> </td>";


            if($bulan_stnk < $bulan_acuan && $tahun_acuan == $tahun_stnk ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_stnk</td>";
            }
            else if($bulan_stnk == $bulan_acuan && $tahun_acuan == $tahun_stnk ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_stnk</td>";
            }
            else{
                echo"<td style='font-size: 14px' align = 'center'>$tanggal_stnk</td>";
            }


            echo" <td style='font-size: 14px'>"; ?> <a download="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_tera_tangki ?>" href="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_tera_tangki ?>"> <?php echo "$file_tera_tangki </a> </td>";
            
            if($bulan_tera_tangki < $bulan_acuan && $tahun_acuan == $tahun_tera_tangki ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_tera_tangki</td>";
            }
            else if($bulan_tera_tangki == $bulan_acuan && $tahun_acuan == $tahun_tera_tangki ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_tera_tangki</td>";
            }
            else{
                echo"<td style='font-size: 14px' align = 'center'>$tanggal_tera_tangki</td>";
            }


            echo" <td style='font-size: 14px'>"; ?> <a download="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_tera_flowmeter ?>" href="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_tera_flowmeter ?>"> <?php echo "$file_tera_flowmeter </a> </td>";

            if($bulan_flowmeter < $bulan_acuan && $tahun_acuan == $tahun_flowmeter ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_tera_flowmeter</td>";
            }
            else if($bulan_flowmeter == $bulan_acuan && $tahun_acuan == $tahun_flowmeter ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_tera_flowmeter</td>";
            }
            else{
                echo"<td style='font-size: 14px' align = 'center'>$tanggal_tera_flowmeter</td>";
            }

           
            echo" <td style='font-size: 14px'>"; ?> <a download="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_kir ?>" href="/PT.BALSRI/Administrasi/file_administrasi/<?= $file_kir ?>"> <?php echo "$file_kir </a> </td>";

            if($bulan_kir < $bulan_acuan && $tahun_acuan == $tahun_kir ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_kir</td>";
            }
            else if($bulan_kir == $bulan_acuan && $tahun_acuan == $tahun_kir ){

                echo"<td style='font-size: clamp(12px, 1vw, 15px); color: #FF0000; font-weight: bold;' align = 'center'>$tanggal_kir</td>";
            }
            else{
                echo"<td style='font-size: 14px' align = 'center'>$tanggal_kir</td>";
            }

         echo"  </tr>";
         } 

?>

</tbody>
</table>
</div>

<br>
<hr>
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
      lengthChange: true,
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable( {
      lengthChange: true,
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

<script>
  $(document).ready(function() {
    var table = $('#example3').DataTable( {
      lengthChange: true,
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>

</body>

</html>