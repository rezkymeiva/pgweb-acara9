<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM penduduk WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kecamatan = $_POST['kecamatan'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $sql = "UPDATE penduduk SET kecamatan='$kecamatan', luas='$luas', jumlah_penduduk='$jumlah_penduduk', longitude='$longitude', latitude='$latitude' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<h2>Data berhasil diupdate!</h2>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000); // Mengarahkan kembali ke halaman utama setelah 2 detik
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <h2>Edit Data Penduduk</h2>
    <form method="POST">
        Kecamatan: <input type="text" name="kecamatan" value="<?= $row['kecamatan'] ?>"><br>
        Luas (ha): <input type="text" name="luas" value="<?= $row['luas'] ?>"><br>
        Jumlah Penduduk: <input type="text" name="jumlah_penduduk" value="<?= $row['jumlah_penduduk'] ?>"><br>
        Longitude: <input type="text" name="longitude" value="<?= $row['longitude'] ?>"><br>
        Latitude: <input type="text" name="latitude" value="<?= $row['latitude'] ?>"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
