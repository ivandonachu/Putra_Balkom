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
    'margin-top' => 3,
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
    $table = mysqli_query($koneksi, "SELECT * FROM rekap_gaji_mes WHERE tanggal  BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
    
    while($data = mysqli_fetch_array($table)){

        $nama_karyawan =$data['nama_karyawan'];
        $jabatan = $data['jabatan'];
        $gaji_pokok = $data['gaji_pokok'];
        $tunjangan_jabatan = $data['tunjangan_jabatan'];
        $tunjangan_operasional = $data['tunjangan_operasional'];
        $tunjangan_akomodasi = $data['tunjangan_akomodasi'];
        $bpjs_kesehatan = $data['bpjs_kesehatan'];
        $bpjs_ketenagakerjaan = $data['bpjs_ketenagakerjaan'];
        $asuransi = $bpjs_kesehatan + $bpjs_ketenagakerjaan;
        $uang_makan_bulan = $data['uang_makan_bulan'];
        $fee_kehadiran = $data['fee_kehadiran'];
        $lembur = $data['lembur'];
        $absen_terlambat = $data['absen_terlambat'];
        $denda_absen = $data['denda_absen'];
        $angsuran_bon_bulanan = $data['angsuran_bon_bulanan'];
        $bonus = $data['bonus'];
        $total_gaji_diterima = $data['total_gaji_diterima'];
        $keterangan = $data['keterangan'];

        $html .= '
        
        <h3 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><img style=" max-height: 70px; width: 100%; text-align:center; " src="../gambar/Kop MES.jpg"> </h3>
        <hr style = "margin-bottom: 1px; margin-top: 1px;">
        <h5 class="panel-title" align="Center" style = "margin-bottom: 1px; margin-top: 1px;"><u><strong>Slip Gaji Karyawan</strong></u></h5>
        <pre class="panel-title" align="center"  style="font-size: 10px; margin-bottom: 10px; margin-top: 1px;">'. $bulan .' '. $tahun .'</pre>

        <table  align="center" style="width:100%">
        <tr>
            <td align="left" style="font-size: 10px; width:20%; ">Nama Karyawan</td>
            <td align="center" style="font-size: 10px; width:1%;"> : </td>
            <td align="left" style="font-size: 10px; width:79%;">'. $nama_karyawan .'</td>
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
        <td align="left" style="font-size: 10px; width:30%; ">Gaji Pokok</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($gaji_pokok) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Tunjangan Jabatan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($tunjangan_jabatan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Tunjangan Operasional</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($tunjangan_operasional) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Tunjangan Akomodasi</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($tunjangan_akomodasi) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Asuransi</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($asuransi) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Uang Makan per Bulan</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($uang_makan_bulan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Fee Kehadiran</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($fee_kehadiran) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Lembur</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($lembur) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Bonus</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($bonus) .'</td>
        </tr>
    
        </table>

        <br>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Absen</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($denda_absen + $absen_terlambat) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Bon</td>
        <td align="right" style="font-size: 10px; width:79%;">'. formatuangx($angsuran_bon_bulanan) .'</td>
        </tr>
        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Potongan Lain - lain</td>
        <td align="right" style="font-size: 10px; width:79%;"></td>
        </tr>
    
        </table>

        <br>

        <table align="center" style="width:100%" border="1" cellspacing="0">

        <tr>
        <td align="left" style="font-size: 10px; width:30%; ">Total Gaji di Terima</td>
        <td align="right" style="font-size: 10px; width:79%; "><strong>'. formatuangx($total_gaji_diterima) .'</strong></td>
        </tr>

        </table>


        <pre class="panel-title" align="left"  style="font-size: 10px; margin-bottom: 5px; margin-top: 5px;"><u>Gaji '. $keterangan .' </u></pre>


        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">Karyawan</td>
        <td align="center" style="font-size: 10px; width:50%;">Direktur</td>
        </tr>
    
        </table>
        <br>
        <br>
        <table align="center" style="width:100%">

        <tr>
        <td align="center" style="font-size: 10px; width:50%; ">'.$nama_karyawan.'</td>
        <td align="center" style="font-size: 10px; width:50%;">Nyoman Edy Susanto</td>
        </tr>
    
        </table>


        <hr style = "margin-bottom: 5px; margin-top: 1px;">
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