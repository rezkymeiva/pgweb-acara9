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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete the record
    $sql = "DELETE FROM penduduk WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Data anda telah berhasil dihapus.</h2>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php'; // Redirect to the main page after 2 seconds
                }, 2000);
              </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
