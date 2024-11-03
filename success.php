<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background-color: #f0f0f0; 
            font-family: Arial, sans-serif; 
        }
        .message { 
            text-align: center; 
            padding: 20px; 
            border: 2px solid green; 
            background-color: white; 
            border-radius: 5px; 
        }
    </style>
    <script>
        // Redirect back to index.php after 4 seconds
        setTimeout(function() {
            window.location.href = "index.php"; // Change 'index.php' to your main page
        }, 4000);
    </script>
</head>
<body>
    <div class="message">
        <h1>Data Berhasil Ditambahkan</h1>
        <p>Anda akan diarahkan kembali dalam 4 detik.</p>
    </div>
</body>
</html>
