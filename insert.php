<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kecamatan = $_POST['kecamatan'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    // SQL statement to insert data
    $sql = "INSERT INTO penduduk (kecamatan, luas, jumlah_penduduk, longitude, latitude) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddss", $kecamatan, $luas, $jumlah_penduduk, $longitude, $latitude);

    // Execute statement
    if ($stmt->execute()) {
        // Redirect to the success page after successful insertion
        header("Location: success.php"); // Redirect to the success page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
