
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
$jabatan_valid = $data1['jabatan'];
if ($jabatan_valid == 'Keuangan') {

}

else{  header("Location: logout.php");
exit;
}
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan = '$id1'");
$data = mysqli_fetch_array($result);
$nama = $data['nama_karyawan'];


if (isset($_GET['tanggal1'])) {
  $tanggal_awal = $_GET['tanggal1'];
  $tanggal_akhir = $_GET['tanggal2'];
  $bulan_sebelum = date('Y-m-d', strtotime('-3 month', strtotime($tanggal_awal)));
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 month', strtotime($tanggal_akhir)));
} elseif (isset($_POST['tanggal1'])) {
  $tanggal_awal = $_POST['tanggal1'];
  $tanggal_akhir = $_POST['tanggal2'];
  $bulan_sebelum = date('Y-m-d', strtotime('-3 month', strtotime($tanggal_awal)));
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 month', strtotime($tanggal_akhir)));
} else {
  $tanggal_awal = date('Y-m-1');
  $tanggal_akhir = date('Y-m-31');
  $bulan_sebelum = date('Y-m-d', strtotime('-3 month', strtotime($tanggal_awal)));
  $bulan_sesudah =  date('Y-m-d', strtotime('+1 month', strtotime($tanggal_akhir)));
}

if ($tanggal_awal == $tanggal_akhir) {
  $table = mysqli_query($koneksipbj, "SELECT * FROM pembelian_sl WHERE tanggal = '$tanggal_akhir' ");
  //Curah OPC Type 1 Debit
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_debit ,  SUM(jumlah) AS uang_copct1_debit  FROM pembelian_sl WHERE 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Curah OPC Type 1'");

  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1_debit = $data2['penjualan_copct1_debit'];
  $uang_copct1_debit = $data2['uang_copct1_debit'];

  //Curah OPC Type 1 Tunai
  $table21 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_tunai ,  SUM(jumlah) AS uang_copct1_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Curah OPC Type 1'");
  $data21 = mysqli_fetch_array($table21);
  $penjualan_copct1_tunai = $data21['penjualan_copct1_tunai'];
  $uang_copct1_tunai = $data21['uang_copct1_tunai'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon = $data22['uang_copct1_bon'];

  //Curah PCC Debit
  $table3 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_debit ,  SUM(jumlah) AS uang_cpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Curah PCC' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Curah PCC'");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc_debit = $data3['penjualan_cpcc_debit'];
  $uang_cpcc_debit = $data3['uang_cpcc_debit'];

  //Curah PCC Tunai
  $table31 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_tunai ,  SUM(jumlah) AS uang_cpcc_tunai  FROM pembelian_sl WHERE 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Curah PCC'OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Curah PCC'");
  $data31 = mysqli_fetch_array($table31);
  $penjualan_cpcc_tunai = $data31['penjualan_cpcc_tunai'];
  $uang_cpcc_tunai = $data31['uang_cpcc_tunai'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM pembelian_sl WHERE 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Curah PCC'OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon = $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 Debit
  $table4 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_debit ,  SUM(jumlah) AS uang_bbopct1_debit  FROM pembelian_sl WHERE 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Big Bag OPC Type 1' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'UltraPro JB'");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bbopct1_debit = $data4['penjualan_bbopct1_debit'];
  $uang_bbopct1_debit = $data4['uang_bbopct1_debit'];

  //Big Bag OPC Type 1 Tunai
  $table41 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_tunai ,  SUM(jumlah) AS uang_bbopct1_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Big Bag OPC Type 1' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'UltraPro JB'");
  $data41 = mysqli_fetch_array($table41);
  $penjualan_bbopct1_tunai = $data41['penjualan_bbopct1_tunai'];
  $uang_bbopct1_tunai = $data41['uang_bbopct1_tunai'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_bon ,  SUM(jumlah) AS uang_bbopct1_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Big Bag OPC Type 1' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'UltraPro JB'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bbopct1_bon = $data42['penjualan_bbopct1_bon'];
  $uang_bbopct1_bon = $data42['uang_bbopct1_bon'];

  //Big Bag PCC Debit
  $table5 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_debit ,  SUM(jumlah) AS uang_bbpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Big Bag PCC' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'EzPro JB'");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bbpcc_debit = $data5['penjualan_bbpcc_debit'];
  $uang_bbpcc_debit = $data5['uang_bbpcc_debit'];

  //Big Bag PCC Tunai
  $table51 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_tunai ,  SUM(jumlah) AS uang_bbpcc_tunai  FROM pembelian_sl WHERE 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Big Bag PCC' OR 
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'EzPro JB'");
  $data51 = mysqli_fetch_array($table51);
  $penjualan_bbpcc_tunai = $data51['penjualan_bbpcc_tunai'];
  $uang_bbpcc_tunai = $data51['uang_bbpcc_tunai'];

  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_bon ,  SUM(jumlah) AS uang_bbpcc_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Big Bag PCC' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'EzPro JB'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bbpcc_bon = $data52['penjualan_bbpcc_bon'];
  $uang_bbpcc_bon = $data52['uang_bbpcc_bon'];

  //Sak PCC 50 Kg Debit
  $table6 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_debit ,  SUM(jumlah) AS uang_sakpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Debit' AND material = 'SEMEN PCC ZAK 50KG'");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc_debit = $data6['penjualan_sakpcc_debit'];
  $uang_sakpcc_debit = $data6['uang_sakpcc_debit'];

  //Sak PCC 50 Kg Tunai
  $table61 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_tunai ,  SUM(jumlah) AS uang_sakpcc_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Tunai' AND material = 'SEMEN PCC ZAK 50KG'");
  $data61 = mysqli_fetch_array($table61);
  $penjualan_sakpcc_tunai = $data61['penjualan_sakpcc_tunai'];
  $uang_sakpcc_tunai = $data61['uang_sakpcc_tunai'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon   FROM pembelian_sl WHERE  
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal = '$tanggal_awal' AND tipe_bayar = 'Bon' AND material = 'SEMEN PCC ZAK 50KG'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon = $data62['uang_sakpcc_bon'];
} else {
  $table = mysqli_query($koneksipbj, "SELECT * FROM pembelian_sl WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  ");
  //Curah OPC Type 1 Debit
  $table2 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_debit ,  SUM(jumlah) AS uang_copct1_debit  FROM pembelian_sl WHERE 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Curah OPC Type 1'");

  $data2 = mysqli_fetch_array($table2);
  $penjualan_copct1_debit = $data2['penjualan_copct1_debit'];
  $uang_copct1_debit = $data2['uang_copct1_debit'];

  //Curah OPC Type 1 Tunai
  $table21 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_tunai ,  SUM(jumlah) AS uang_copct1_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Curah OPC Type 1'");
  $data21 = mysqli_fetch_array($table21);
  $penjualan_copct1_tunai = $data21['penjualan_copct1_tunai'];
  $uang_copct1_tunai = $data21['uang_copct1_tunai'];

  //Curah OPC Type 1 Bon
  $table22 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_copct1_bon ,  SUM(jumlah) AS uang_copct1_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Curah OPC Type 1' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Curah OPC Type 1'");
  $data22 = mysqli_fetch_array($table22);
  $penjualan_copct1_bon = $data22['penjualan_copct1_bon'];
  $uang_copct1_bon = $data22['uang_copct1_bon'];

  //Curah PCC Debit
  $table3 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_debit ,  SUM(jumlah) AS uang_cpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Curah PCC' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Curah PCC'");
  $data3 = mysqli_fetch_array($table3);
  $penjualan_cpcc_debit = $data3['penjualan_cpcc_debit'];
  $uang_cpcc_debit = $data3['uang_cpcc_debit'];

  //Curah PCC Tunai
  $table31 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_tunai ,  SUM(jumlah) AS uang_cpcc_tunai  FROM pembelian_sl WHERE 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Curah PCC'OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Curah PCC'");
  $data31 = mysqli_fetch_array($table31);
  $penjualan_cpcc_tunai = $data31['penjualan_cpcc_tunai'];
  $uang_cpcc_tunai = $data31['uang_cpcc_tunai'];

  //Curah PCC Bon
  $table32 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_cpcc_bon ,  SUM(jumlah) AS uang_cpcc_bon  FROM pembelian_sl WHERE 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Curah PCC'OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Curah PCC'");
  $data32 = mysqli_fetch_array($table32);
  $penjualan_cpcc_bon = $data32['penjualan_cpcc_bon'];
  $uang_cpcc_bon = $data32['uang_cpcc_bon'];

  //Big Bag OPC Type 1 Debit
  $table4 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_debit ,  SUM(jumlah) AS uang_bbopct1_debit  FROM pembelian_sl WHERE 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Big Bag OPC Type 1' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'UltraPro JB'");
  $data4 = mysqli_fetch_array($table4);
  $penjualan_bbopct1_debit = $data4['penjualan_bbopct1_debit'];
  $uang_bbopct1_debit = $data4['uang_bbopct1_debit'];

  //Big Bag OPC Type 1 Tunai
  $table41 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_tunai ,  SUM(jumlah) AS uang_bbopct1_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Big Bag OPC Type 1' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'UltraPro JB'");
  $data41 = mysqli_fetch_array($table41);
  $penjualan_bbopct1_tunai = $data41['penjualan_bbopct1_tunai'];
  $uang_bbopct1_tunai = $data41['uang_bbopct1_tunai'];

  //Big Bag OPC Type 1 Bon
  $table42 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbopct1_bon ,  SUM(jumlah) AS uang_bbopct1_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Big Bag OPC Type 1' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'UltraPro JB'");
  $data42 = mysqli_fetch_array($table42);
  $penjualan_bbopct1_bon = $data42['penjualan_bbopct1_bon'];
  $uang_bbopct1_bon = $data42['uang_bbopct1_bon'];

  //Big Bag PCC Debit
  $table5 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_debit ,  SUM(jumlah) AS uang_bbpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Big Bag PCC' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_bayar = 'Debit' AND material = 'EzPro JB'");
  $data5 = mysqli_fetch_array($table5);
  $penjualan_bbpcc_debit = $data5['penjualan_bbpcc_debit'];
  $uang_bbpcc_debit = $data5['uang_bbpcc_debit'];

  //Big Bag PCC Tunai
  $table51 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_tunai ,  SUM(jumlah) AS uang_bbpcc_tunai  FROM pembelian_sl WHERE 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'Big Bag PCC' OR 
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Tunai' AND material = 'EzPro JB'");
  $data51 = mysqli_fetch_array($table51);
  $penjualan_bbpcc_tunai = $data51['penjualan_bbpcc_tunai'];
  $uang_bbpcc_tunai = $data51['uang_bbpcc_tunai'];

  //Big Bag PCC Bon
  $table52 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_bbpcc_bon ,  SUM(jumlah) AS uang_bbpcc_bon  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Big Bag PCC' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'EzPro JB'");
  $data52 = mysqli_fetch_array($table52);
  $penjualan_bbpcc_bon = $data52['penjualan_bbpcc_bon'];
  $uang_bbpcc_bon = $data52['uang_bbpcc_bon'];

  //Sak PCC 50 Kg Debit
  $table6 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_debit ,  SUM(jumlah) AS uang_sakpcc_debit  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Debit' AND material = 'SEMEN PCC ZAK 50KG'");
  $data6 = mysqli_fetch_array($table6);
  $penjualan_sakpcc_debit = $data6['penjualan_sakpcc_debit'];
  $uang_sakpcc_debit = $data6['uang_sakpcc_debit'];

  //Sak PCC 50 Kg Tunai
  $table61 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_tunai ,  SUM(jumlah) AS uang_sakpcc_tunai  FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_bayar = 'Tunai' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND tipe_bayar = 'Tunai' AND material = 'SEMEN PCC ZAK 50KG'");
  $data61 = mysqli_fetch_array($table61);
  $penjualan_sakpcc_tunai = $data61['penjualan_sakpcc_tunai'];
  $uang_sakpcc_tunai = $data61['uang_sakpcc_tunai'];

  //Sak PCC 50 Kg Bon
  $table62 = mysqli_query($koneksipbj, "SELECT SUM(qty) AS penjualan_sakpcc_bon ,  SUM(jumlah) AS uang_sakpcc_bon   FROM pembelian_sl WHERE  
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'Sak PCC 50 Kg' OR
                                                                                                                      tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  AND tipe_bayar = 'Bon' AND material = 'SEMEN PCC ZAK 50KG'");
  $data62 = mysqli_fetch_array($table62);
  $penjualan_sakpcc_bon = $data62['penjualan_sakpcc_bon'];
  $uang_sakpcc_bon = $data62['uang_sakpcc_bon'];
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

  <title>Penebusan Semen</title>

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
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="DsKeuangan">
    <div class="sidebar-brand-icon rotate-n-15">

    </div>
    <div class="sidebar-brand-text mx-3" > <img style="height: 65px; width: 220px;" src="../gambar/Logo CBM.jpg" ></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active" >
    <a class="nav-link" href="DsKeuangan">
        <i class="fas fa-fw fa-tachometer-alt" style="font-size: 18px;"></i>
        <span style="font-size: 16px;" >Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading" style="font-size: 15px; color:white;">
         Menu Keuangan
    </div>
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
      15  aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >LR Kendaraan</span>
    </a>
    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">LR Kendaraan</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi2">LR Kendaraan Lampung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiP2">LR Kendaraan Sumsel</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBr">LR Kendaraan Baturaja</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBl">LR Kendaraan Belitung</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiBk">LR Kendaraan Bangka</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugi">LR Kendaraan Bengkulu</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPA">LR Kendaraan Padlarang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiPL">LR Kendaraan Plumpang</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiTG">LR Kendaraan Tj Gerem</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLabaRugiUB">LR Kendaraan Uj Berung</a>
        </div>
    </div>
</li>
     <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2"
      15  aria-expanded="true" aria-controls="collapse2">
        <i class="fas fa-cash-register" style="font-size: 15px; color:white;" ></i>
        <span style="font-size: 15px; color:white;" >Data PBJ</span>
    </a>
    <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="font-size: 15px;">Data PBJ</h6>
            <a class="collapse-item" style="font-size: 15px;" href="VPenebusan">Penebusan PBJ</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualan">Penjualan Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPenjualanL">Penjualan Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuangan">Keuangan Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="VKeuanganL">Keuangan Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengiriman">Pengiriman Ety</a>
            <a class="collapse-item" style="font-size: 15px;" href="VPengirimanL">Pengiriman Agus</a>
            <a class="collapse-item" style="font-size: 15px;" href="VLStokGudang">Laporan Stok Gudang</a>
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
          <?php echo "<a href='VPenebusan?tanggal1=$tanggal_awal&tanggal2=$tanggal_akhir'><h5 class='text-center sm' style='color:white; margin-top: 8px;  '>Penebusan Semen</h5></a>"; ?>

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


            <?php echo "<form  method='POST' action='VPenebusan' style='margin-bottom: 15px;'>" ?>
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





            <!-- Tabel -->
            <div style="overflow-x: auto" align='center'>
              <table id="example" class="table-sm table-striped table-bordered  nowrap" style="width:auto">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NO DO</th>
                    <th>NO SO</th>
                    <th>Brand</th>
                    <th>Tipe Semen</th>
                    <th>Tujuan</th>
                    <th>Kota</th>
                    <th>Material</th>
                    <th>QTY</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Driver</th>
                    <th>No Polisi</th>
                    <th>Tipe Pembayaran</th>
                    <th>Tempo</th>
                    <th>Ket</th>
                    <th>File</th>

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
                    $no_pembelian = $data['no_pembelian'];
                    $tanggal = $data['tanggal'];
                    $no_do = $data['no_do'];
                    $no_so = $data['no_so'];
                    $brand = $data['brand'];
                    $tipe_semen = $data['tipe_semen'];
                    $tujuan = $data['tujuan'];
                    $kota = $data['kota'];
                    $material = $data['material'];
                    $qty = $data['qty'];
                    $harga = $data['harga'];
                    $jumlah = $data['jumlah'];
                    $driver = $data['driver'];
                    $no_polisi = $data['no_polisi'];
                    $tipe_bayar = $data['tipe_bayar'];
                    $tempo = $data['tempo'];
                    $keterangan = $data['keterangan'];
                    $file_bukti = $data['file_bukti'];
                    $no_urut = $no_urut + 1;


                    echo "<tr>
      <td style='font-size: 14px'>$no_urut</td>
      <td style='font-size: 14px'>$tanggal</td>
      <td style='font-size: 14px'>$no_do</td>
      <td style='font-size: 14px'>$no_so</td>
      <td style='font-size: 14px'>$brand</td>
      <td style='font-size: 14px'>$tipe_semen</td>
      <td style='font-size: 14px'>$tujuan</td>
      <td style='font-size: 14px'>$kota</td>
      <td style='font-size: 14px'>$material</td>
      <td style='font-size: 14px'>$qty</td>
      <td style='font-size: 14px'>"; ?> <?= formatuang($harga); ?> <?php echo "</td>
      <td style='font-size: 14px'>" ?> <?= formatuang($jumlah); ?> <?php echo "</td>
      <td style='font-size: 14px'>$driver</td>
      <td style='font-size: 14px'>$no_polisi</td>
      <td style='font-size: 14px'>$tipe_bayar</td>
      <td style='font-size: 14px'>$tempo</td>
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
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag OPC Type 1 Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbopct1_debit ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag OPC Type 1 Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbopct1_debit) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag OPC Type 1 Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbopct1_tunai  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag OPC Type 1 Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbopct1_tunai) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag OPC Type 1 Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbopct1_bon  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag OPC Type 1 Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbopct1_bon) ?></div>
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
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag PCC Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbpcc_debit ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag PCC Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbpcc_debit) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag PCC Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbpcc_tunai  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag PCC Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbpcc_tunai) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Big Bag PCC Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_bbpcc_bon  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Big Bag PCC Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_bbpcc_bon) ?></div>
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
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah OPC Type 1 Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= round($penjualan_copct1_debit, 3) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah OPC Type 1 Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1_debit) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah OPC Type 1 Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_copct1_tunai  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah OPC Type 1 Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1_tunai) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah OPC Type 1 Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_copct1_bon  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah OPC Type 1 Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_copct1_bon) ?></div>
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
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah PCC Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_cpcc_debit ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah PCC Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc_debit) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah PCC Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_cpcc_tunai  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah PCC Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc_tunai) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Curah PCC Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_cpcc_bon  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Curah PCC Bom</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_cpcc_bon) ?></div>
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
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Sak PCC 50 Kg Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_sakpcc_debit ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Sak PCC 50 Kg Debit</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc_debit) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Sak PCC 50 Kg Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_sakpcc_tunai  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Sak PCC 50 Kg Tunai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc_tunai) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Penebusan Sak PCC 50 Kg Bon</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penjualan_sakpcc_bon  ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Uang Sak PCC 50 Kg Bom</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatuang($uang_sakpcc_bon) ?></div>
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
        lengthChange: true,
        buttons: ['excel']
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