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
if ($jabatan_valid == 'Direktur Utama') {

}

else{ header("Location: logout.php");
exit;
}



if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
  $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
   $bulan_sesudah =  date('Y-m-d', strtotime('+3 day', strtotime($tanggal_akhir))); 
 } 
 
 elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
  $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
   $bulan_sesudah =  date('Y-m-d', strtotime('+3 day', strtotime($tanggal_akhir))); 
 } 
 else{
   $tanggal_awal = date('Y-m-1');
   $tanggal_akhir = date('Y-m-31');
 
   $bulan_sebelum = date('Y-m-d', strtotime('-3 day', strtotime($tanggal_awal))); 
   $bulan_sesudah =  date('Y-m-d', strtotime('+3 day', strtotime($tanggal_akhir))); 
 }

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksipbj,"SELECT * FROM penjualan_sl WHERE tanggal_kirim = '$tanggal_akhir' ");
  //Curah OPC Type 1 bayar
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1 ,  SUM(jumlah) AS uang_copct1  FROM penjualan_sl WHERE  tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah OPC Type 1' OR  tanggal_kirim =  
  '$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah OPC Type 1'  ");
  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1 = $data2['penjualan_copct1'];
  $uang_copct1 = $data2['uang_copct1'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Curah OPC Type 1' 
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon= $data22['uang_copct1_bon'];

  //Curah PCC bayar
  $table3 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc ,  SUM(jumlah) AS uang_cpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah PCC' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah PCC'  ");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc = $data3['penjualan_cpcc'];
  $uang_cpcc = $data3['uang_cpcc'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Curah PCC' 
                                                                                                                              OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon= $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 bayar
  $table4 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bopct1 ,  SUM(jumlah) AS uang_bopct1  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag OPC Type 1' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag OPC Type 1'  ");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bopct1 = $data4['penjualan_bopct1'];
  $uang_bopct1 = $data4['uang_bopct1'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bopct1_bon ,  SUM(jumlah) AS uang_bopct1_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Big Bag OPC Type 1'
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag OPC Type 1'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bopct1_bon = $data42['penjualan_bopct1_bon'];
  $uang_bopct1_bon= $data42['uang_bopct1_bon'];

  //Big Bag PCC bayar
  $table5 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bpcc ,  SUM(jumlah) AS uang_bpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag PCC' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag PCC'  ");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bpcc = $data5['penjualan_bpcc'];
  $uang_bpcc = $data5['uang_bpcc'];

  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bpcc_bon ,  SUM(jumlah) AS uang_bpcc_bon  FROM penjualan_sl WHERE  tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Big Bag PCC'
                                                                                                                              OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag PCC'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bpcc_bon = $data52['penjualan_bpcc_bon'];
  $uang_bpcc_bon= $data52['uang_bpcc_bon'];

  $data42['uang_bopct1_bon'];

  //Sak PCC 50 Kg bayar
  $table6 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc ,  SUM(jumlah) AS uang_sakpcc  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Transfer' AND satuan = 'Sak PCC 50 Kg' OR   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Lunas Cash' AND satuan = 'Sak PCC 50 Kg'  ");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc = $data6['penjualan_sakpcc'];
  $uang_sakpcc = $data6['uang_sakpcc'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon  FROM penjualan_sl WHERE   tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Bon' AND satuan = 'Sak PCC 50 Kg'
                                                                                                                                  OR tanggal_kirim ='$tanggal_awal' AND status_bayar = 'Nyicil' AND satuan = 'Sak PCC 50 Kg'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon= $data62['uang_sakpcc_bon'];

}

else{
  $table = mysqli_query($koneksipbj,"SELECT * FROM penjualan_sl WHERE tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ORDER BY tanggal_kirim ASC");

  //Curah OPC Type 1 bayar
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1 ,  SUM(jumlah) AS uang_copct1  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah OPC Type 1' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah OPC Type 1'  ");
  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1 = $data2['penjualan_copct1'];
  $uang_copct1 = $data2['uang_copct1'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM penjualan_sl WHERE  
                                      tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Curah OPC Type 1' OR
                                      tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon= $data22['uang_copct1_bon'];

  //Curah PCC bayar
  $table3 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc ,  SUM(jumlah) AS uang_cpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Curah PCC' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Curah PCC'  ");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc = $data3['penjualan_cpcc'];
  $uang_cpcc = $data3['uang_cpcc'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Curah PCC' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon= $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 bayar
  $table4 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bopct1 ,  SUM(jumlah) AS uang_bopct1  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag OPC Type 1' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag OPC Type 1'  ");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bopct1 = $data4['penjualan_bopct1'];
  $uang_bopct1 = $data4['uang_bopct1'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bopct1_bon ,  SUM(jumlah) AS uang_bopct1_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Big Bag OPC Type 1' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag OPC Type 1'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bopct1_bon = $data42['penjualan_bopct1_bon'];
  $uang_bopct1_bon= $data42['uang_bopct1_bon'];

  //Big Bag PCC bayar
  $table5 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bpcc ,  SUM(jumlah) AS uang_bpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Big Bag PCC' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Big Bag PCC'  ");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bpcc = $data5['penjualan_bpcc'];
  $uang_bpcc = $data5['uang_bpcc'];
  
  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bpcc_bon ,  SUM(jumlah) AS uang_bpcc_bon  FROM penjualan_sl WHERE 
   tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Big Bag PCC' OR
   tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Big Bag PCC'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bpcc_bon = $data52['penjualan_bpcc_bon'];
  $uang_bpcc_bon= $data52['uang_bpcc_bon'];

  $data42['uang_bopct1_bon'];

  //Sak PCC 50 Kg bayar
  $table6 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc ,  SUM(jumlah) AS uang_sakpcc  FROM penjualan_sl WHERE  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Transfer' AND satuan = 'Sak PCC 50 Kg' OR  tanggal_kirim BETWEEN 
  '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Lunas Cash' AND satuan = 'Sak PCC 50 Kg'  ");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc = $data6['penjualan_sakpcc'];
  $uang_sakpcc = $data6['uang_sakpcc'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon  FROM penjualan_sl WHERE  
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Bon' AND satuan = 'Sak PCC 50 Kg' OR
  tanggal_kirim BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_bayar = 'Nyicil' AND satuan = 'Sak PCC 50 Kg'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon= $data62['uang_sakpcc_bon'];

 

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

  <title>Penjualan Semen</title>

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
                <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluran">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranWorkshop">Pengeluaran Workshop</a>
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
                <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Laporan Penjualan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPenebusanL">Laporan Penebusan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VSewaHiBlow">Sewa Hiblow</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Laporan Pengiriman</a>
                <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Laporan Keuangan</a>
                <a class="collapse-item" style="font-size: 15px;" href="VPengeluaranL">Laporan Pengeluaran</a>
                <a class="collapse-item" style="font-size: 15px;" href="VTonasePembelian">Tonase Pembelian</a>
            </div>
        </div>
    </li>

    <?php if ($nama == 'Nyoman Edy Susanto') {
                echo "
            <!-- Nav Item - Pages Collapse Menu -->
            <li class='nav-item'>
                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseTwo4' 15 aria-expanded='true' aria-controls='collapseTwo4'>
                    <i class='fa fa-clipboard-list' style='font-size: 15px; color:white;'></i>
                    <span style='font-size: 15px; color:white;'>Report Laba Rugi</span>
                </a>
                <div id='collapseTwo4' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
                    <div class='bg-white py-2 collapse-inner rounded'>
                        <h6 class='collapse-header' style='font-size: 15px;'>Report</h6>
                        <a class='collapse-item' style='font-size: 15px;' href='VLR2LBaru'>Laba Rugi</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VLRKendaraan'>Laba Rugi Kendaraan</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapanHarga'>Rekapan Harga</a>
                        <a class='collapse-item' style='font-size: 15px;' href='VRekapSparepart'>Rekap Sparepart</a>
                    </div>
                </div>
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

<!-- Top content -->
<div>   


  <!-- Name Page -->
  <div class="pinggir1" style="margin-right: 20px; margin-left: 20px;">


    <?php  echo "<form  method='POST' action='VPenjualanL' style='margin-bottom: 15px;'>" ?>
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
  <div class="row">
    <div class="col-md-6">
     <?php  echo" <a style='font-size: 12px'> Data yang Tampil  $tanggal_awal  sampai  $tanggal_akhir</a>" ?>
   </div>
</div>




<!-- Tabel -->    
<div style="overflow-x: auto">
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
  <thead>
    <tr>
      <th>No</th>
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
      <th>Nama Toko di DO</th>
      <th>TGL Bayar</th>
      <th>Status Bayar</th>
      <th>Ket</th>
      <th>File</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    $no_urut = 0;
    $total_Curah_OPC_Type1 = 0;
    $total_Curah_PCC = 0;
    $total_Big_Bag_OPC_Type1 = 0;
    $total_Big_Bag_PCC = 0;
    $total_Sak_PCC_50_Kg = 0;
    
    function formatuang($angka){
      $uang = "Rp " . number_format($angka,2,',','.');
      return $uang;
    }

    ?>

    <?php while($data = mysqli_fetch_array($table)){
      $no_penjualan = $data['no_penjualan'];
      $tanggal_kirim =$data['tanggal_kirim'];
      $tanggal_kirim = $data['tanggal_kirim'];
      $no_do = $data['no_do'];
      $driver = $data['driver'];
      $no_polisi = $data['no_polisi'];
      $tujuan_pengiriman = $data['tujuan_pengiriman'];
      $qty = $data['qty'];
      $satuan = $data['satuan'];
      $harga_beli = $data['harga_beli'];
    
      $harga = $data['harga'];
      $jumlah_beli = $qty * $harga;
      $jumlah = $data['jumlah'];
      $toko_do = $data['toko_do'];
      $tempo = $data['tempo'];
      $tanggal_bayar = $data['tanggal_bayar'];
      $status_bayar = $data['status_bayar'];
      $keterangan = $data['keterangan'];
      $bulan = $data['bulan'];
      $file_bukti = $data['file_bukti'];
      $no_urut = $no_urut + 1;

      if($satuan == 'Curah OPC Type 1'){
        $total_Curah_OPC_Type1 = $total_Curah_OPC_Type1 + $jumlah_beli;
      }else if($satuan == 'Curah PCC'){
        $total_Curah_PCC = $total_Curah_PCC + $jumlah_beli;
      }else if($satuan == 'Big Bag OPC Type 1' ){
        $total_Big_Bag_OPC_Type1 = $total_Big_Bag_OPC_Type1 + $jumlah_beli;
      }else if($satuan == 'Big Bag PCC'){
        $total_Big_Bag_PCC = $total_Big_Bag_PCC + $jumlah_beli;
      }else if($satuan == 'Sak PCC 50 Kg'){
        $total_Sak_PCC_50_Kg = $total_Sak_PCC_50_Kg + $jumlah_beli;
      }

      echo "<tr>
      <td style='font-size: 14px'>$no_urut</td> 
      <td style='font-size: 14px'>$tanggal_kirim</td>
      <td style='font-size: 14px'>$tanggal_kirim</td>
      <td style='font-size: 14px'>$no_do</td>
      <td style='font-size: 14px'>$driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$tujuan_pengiriman</td>
      <td style='font-size: 14px'>$satuan</td>
      <td style='font-size: 14px'>$qty</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga_beli); ?> <?php echo "</td>
      <td style='font-size: 14px'>";?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>"?>  <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$toko_do</td>
      <td style='font-size: 14px'>$tanggal_bayar</td>
      <td style='font-size: 14px'>$status_bayar</td>
      <td style='font-size: 14px'>$keterangan</td>
      <td style='font-size: 14px'>"; ?> <a download="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>" href="/CV.PBJ/AdminSemen/file_admin_semen/<?= $file_bukti ?>"> <?php echo "$file_bukti </a> </td>
      "; ?>
   



<?php echo  " </tr>";
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
            Total Penjualan Big Bag OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  $penjualan_bopct1 ?></div>
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
            Total Uang Big Bag OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($uang_bopct1) ?></div>
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
            Total Big Bag OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bopct1_bon  ?></div>
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
            Total Uang Big Bag OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=formatuang($uang_bopct1_bon)?></div>
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
<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Big Bag PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_bpcc   ?></div>
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
            Total Uang Big Bag PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bpcc) ?></div>
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
            Total Big Bag PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bpcc_bon ?></div>
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
            Total Uang Big Bag PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bpcc_bon)?></div>
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

<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Curah OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    round($penjualan_copct1,3)   ?></div>
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
            Total Uang Curah OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1) ?></div>
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
            Total Curah OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_copct1_bon  ?></div>
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
            Total Uang Curah OPC Type 1 BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1_bon)?></div>
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


<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Curah PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_cpcc  ?></div>
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
            Total Uang Curah PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc) ?></div>
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
            Total Curah PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_cpcc_bon  ?></div>
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
            Total Uang Curah PCC BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc_bon)?></div>
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


<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Penjualan Sak PCC 50 Kg</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_sakpcc   ?></div>
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
            Total Uang Sak PCC 50 Kg</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc) ?></div>
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
            Total Sak PCC 50 Kg BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_sakpcc_bon  ?></div>
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
            Total Uang Sak PCC 50 Kg BON</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc_bon)?></div>
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
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Seluruh QTY </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    $penjualan_bopct1 + $penjualan_bopct1_bon + $penjualan_bpcc + $penjualan_bpcc_bon + $penjualan_copct1 + $penjualan_copct1_bon + $penjualan_cpcc + $penjualan_cpcc_bon + $penjualan_sakpcc + $penjualan_sakpcc_bon ?></div>
          </div>
          <div class="col-auto">
             <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Seluruh Uang</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=  formatuang($uang_bopct1 + $uang_bopct1_bon + $uang_bpcc + $uang_bpcc_bon + $uang_copct1 + $uang_copct1_bon + $uang_cpcc + $uang_cpcc_bon + $uang_sakpcc + $uang_bpcc_bon + $uang_sakpcc_bon) ?></div>
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


<div class="row" style="margin-right: 20px; margin-left: 20px;">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Uang Pembelian Sak PCC 50 Kg</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=    formatuang($total_Sak_PCC_50_Kg)   ?></div>
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
            Uang Pembelian Curah OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_Curah_OPC_Type1) ?></div>
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
            Uang Pembelian Big Bag OPC Type 1</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_Big_Bag_OPC_Type1)  ?></div>
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
            Uang Pembelian Big Bag PCC</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_Big_Bag_PCC)?></div>
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
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
            Total Seluruh Pembelian </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($total_Big_Bag_PCC + $total_Big_Bag_OPC_Type1 + $total_Curah_OPC_Type1 + $total_Sak_PCC_50_Kg)?></div>
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
    var table = $('#example').DataTable( {
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
<script>
  function createOptions(number) {
    var options = [], _options;

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

  $('#special').on('click', function () {
    mySelect.find('option:selected').prop('disabled', true);
    mySelect.selectpicker('refresh');
  });

  $('#special2').on('click', function () {
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