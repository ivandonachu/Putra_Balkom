<?php
require_once 'vendor/autoload.php';
include 'koneksi.php';


    $tanggal_awal = $_GET['tanggal1'];
    $tanggal_akhir = $_GET['tanggal2'];
    $tahun = date('Y', strtotime($tanggal_awal));
    $bulan = date('M', strtotime($tanggal_awal)); 


?>
  <style>
   tr{
    border-bottom: 2pt solid;
   }
  </style>

<?php

function formatuang($angka)
{
    $uang = number_format($angka, 0, ',', '.');
    return $uang;
}
function formatuangx($angka)
{
    $uang = "Rp " . number_format($angka, 0, ',', '.');
    return $uang;
}

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [210, 297]  ]);
$mpdf->AddPageByArray([
    'margin-left' => 20,
    'margin-right' => 20,
    'margin-top' => 5,
    'margin-bottom' => 5,
]);
$html = '
<html>

<head>


</head>

<body>
<br>
<br>

          
       


';
    $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_driver_pbr WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    
    while($data = mysqli_fetch_array($table)){

        $tanggal =$data['tanggal'];
        $nama_driver =$data['nama_driver'];
        $jabatan = $data['jabatan'];
        $rit_nje = $data['rit_nje'];
        $upah_nje = $data['upah_nje'];
        $rit_gas_palembang = $data['rit_gas_palembang'];
        $upah_gas_palembang = $data['upah_gas_palembang'];
        $bpjs_kesehatan = $data['bpjs_kesehatan'];
        $bpjs_ketenagakerjaan = $data['bpjs_ketenagakerjaan'];
        $asuransi = $bpjs_kesehatan + $bpjs_ketenagakerjaan;
        $angsuran_bon_bulanan = $data['angsuran_bon_bulanan'];
        $total_gaji = $data['total_gaji'];
        $total_gaji_diterima = $data['total_gaji_diterima'];
        $keterangan = $data['keterangan'];

        $html .= '
        
        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " src="../gambar/Kop PBR.jpg"> </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h5 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Slip Gaji Karyawan</strong></u></h5>
        <pre class="panel-title" align="center"  style="font-size: 10px; margin-bottom: 10px; margin-top: 1px;">'. $bulan .' '. $tahun .'</pre>

        <table  align="center" style="width:100%">
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Nama Karyawan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $nama_driver .'</td>
        </tr>
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Jabatan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $jabatan .'</td>
        </tr>
        </table>
        <br>
        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Ritase PPE</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_nje .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah PPE</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_nje) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Ritase PEP</td>
        <td align="right" style="font-size: 10px; width:79%;">'. $rit_gas_palembang .' Rit</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Upah PEP</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($upah_gas_palembang) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Asuransi</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($asuransi) .'</td>
        </tr>
    
        </table>

        <br>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Bon</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($angsuran_bon_bulanan) .'</td>
        </tr>
    
        </table>

        <br>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji) .'</strong></td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji di Terima</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji_diterima) .'</strong></td>
        </tr>

        </table>


        <pre class="panel-title" align="left"  style="font-size: 10px; margin-bottom: 5px; margin-top: 5px;"><u>Gaji '. $keterangan .' </u></pre>


        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">Driver</td>
        <td align="center" style="font-size: 10px; width:50%; ">Direktur</td>
        </tr>
    
        </table>
        <br>
        <br>
        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">'.$nama_driver.'</td>
        <td align="center" style="font-size: 10px; width:50%;">Nyoman Edy Susanto</td>
        </tr>
    
        </table>


        <hr style = "margin-bottom: 5px; margin-top: 1px;">
        <br>
        <br>
        <br>
        <br>
     



        
        ';

        

    } 



    $html .= '';

    





 $html .= '</body>

</html>';

$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>