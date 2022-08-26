
<!DOCTYPE html>
<html>

<?php
echo "Access OK";
echo "<br>"; //newline

if (isset($_GET['tag'])){
	$data = $_GET['tag'];
	echo $data;
}
else{
	echo "Data not received";
}


$tanggal =  date("Y-m-d H:i:s");

//Connect ke database
include ("koneksi.php");
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql =  mysqli_query($koneksi,"INSERT INTO riwayat_absensi VALUES ('','$data','$tanggal',0000-00-00)");

if ($conn->query($sql) === TRUE) {
echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
} else {
echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $conn->error."');</script>";
}

$conn->close();

?>

?>

</html>
