<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet JS - WEB GIS KAPANEWON WILAYAH YOGYAKARTA</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* General styling for the page */
        html, body { height: 100%; margin: 0; padding: 0; }
        #map { width: 100%; height: 600px; }
        
        /* Header styling */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: brown;
            padding: 10px 20px;
        }
        
        h1 { 
            margin: 0; 
            color: white; 
        }

        /* Navbar styling */
        .navbar {
            display: flex;
        }
        .navbar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        
        /* Table styling */
        h2 { text-align: center; margin: 20px 0; background-color: brown; color: white; padding: 10px; }
        .popup-table, table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .popup-table th, .popup-table td, table th, table td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        table th { background-color: #f2f2f2; }
        .action-btn { padding: 5px 10px; border: none; text-decoration: none; border-radius: 4px; cursor: pointer; }
        .delete-btn { color: white; background-color: red; }
        .edit-btn { color: white; background-color: blue; }
        .add-btn { background-color: green; color: white; margin: 20px; padding: 10px; border: none; cursor: pointer; }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>WEB GIS KAPANEWON WILAYAH YOGYAKARTA</h1>
        <div class="navbar">
            <a href="#map">Peta</a>
            <a href="#population-table">Tabel Penduduk</a>
            <a href="#" onclick="showAboutPopup()">Tentang</a>
        </div>
    </div>

    <div id="map"></div>
    
    <h2 id="population-table">DAFTAR JUMLAH PENDUDUK KAPANEWON YOGYAKARTA</h2>
    
    <!-- Button to add data -->
    <button class="add-btn" onclick="document.getElementById('addDataModal').style.display='block'">Tambah Data</button>

    <!-- Modal for Adding Data -->
    <div id="addDataModal" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; max-width:400px; margin:auto;">
            <h3>Tambah Data</h3>
            <form action="insert.php" method="POST">
                <label>Kecamatan:</label><br>
                <input type="text" name="kecamatan" required><br>
                <label>Luas (ha):</label><br>
                <input type="number" name="luas" step="0.01" required><br>
                <label>Jumlah Penduduk:</label><br>
                <input type="number" name="jumlah_penduduk" required><br>
                <label>Longitude:</label><br>
                <input type="text" name="longitude" required><br>
                <label>Latitude:</label><br>
                <input type="text" name="latitude" required><br>
                <button type="submit">Simpan</button>
                <button type="button" onclick="document.getElementById('addDataModal').style.display='none'">Batal</button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kecamatan</th>
                <th>Luas (ha)</th>
                <th>Jumlah Penduduk</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "pgweb8";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM penduduk";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $kecamatan = $row["kecamatan"];
                    $luas = $row["luas"];
                    $jumlah_penduduk = $row["jumlah_penduduk"];
                    $longitude = $row["longitude"];
                    $latitude = $row["latitude"];

                    echo "<tr>
                            <td>$kecamatan</td>
                            <td>$luas</td>
                            <td>$jumlah_penduduk</td>
                            <td>$longitude</td>
                            <td>$latitude</td>
                            <td>
                                <a href='edit.php?id=$id' class='action-btn edit-btn'>Edit</a>
                                <a href='delete.php?id=$id' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                            </td>
                          </tr>\n";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data ditemukan</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- About Popup -->
    <div id="aboutModal" class="modal">
        <div class="modal-content">
            <h3>Tentang Pembuat</h3>
            <p>Ini adalah website GIS yang dibuat oleh Rezky Meiva Anisa. Website ini bertujuan untuk memetakan data penduduk di Kapanewon Wilayah Yogyakarta.</p>
            <button onclick="document.getElementById('aboutModal').style.display='none'">Tutup</button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Function to show the About popup
        function showAboutPopup() {
            document.getElementById('aboutModal').style.display = 'flex';
        }

        // Inisialisasi peta dan set tampilan awal
        var map = L.map("map").setView([-7.783729720556163, 110.39697942221997], 12);

        // Tambahkan lapisan OpenStreetMap
        var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });

        // Tambahkan lapisan Stamen Terrain
        var terrain = L.tileLayer("https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}.jpg", {
            attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under ODbL.',
            minZoom: 0,
            maxZoom: 20,
        });

        // Tambahkan semua base layer ke peta
        var baseMaps = {
            "OpenStreetMap": osm,
            "Stamen Terrain": terrain
        };

        // Set OpenStreetMap as the default layer
        osm.addTo(map);

        // Control to switch between base layers
        L.control.layers(baseMaps).addTo(map);

        // Menambahkan marker dari database ke peta
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM penduduk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row["latitude"];
                $long = $row["longitude"];
                $kecamatan = $row["kecamatan"];
                $luas = $row["luas"];
                $jumlah_penduduk = $row["jumlah_penduduk"];

                echo "var marker = L.marker([$lat, $long]).addTo(map).bindTooltip('$kecamatan', { permanent: true, direction: 'top' });\n";
                echo "marker.on('click', function() { this.bindPopup('<table class=\"popup-table\">' +
                        '<tr><th>Kecamatan</th><td>$kecamatan</td></tr>' +
                        '<tr><th>Luas (ha)</th><td>$luas</td></tr>' +
                        '<tr><th>Jumlah Penduduk</th><td>$jumlah_penduduk</td></tr>' +
                        '<tr><th>Longitude</th><td>$long</td></tr>' +
                        '<tr><th>Latitude</th><td>$lat</td></tr>' +
                        '</table>').openPopup(); });\n";
            }
        }

        $conn->close();
        ?>
    </script>
</body>
</html>
