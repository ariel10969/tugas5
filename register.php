<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #45a049;
        }
        .register-container .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-container .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .register-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
        <input type="text" name="name" placeholder="Nama Lengkap" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>

        
<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'user_database';
$username = 'root';
$password = '';

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
    echo "";
    exit;
}

// Ambil data dari form
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password untuk keamanan

// Query untuk memasukkan data ke dalam tabel
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registrasi berhasil. <a href='login.php'>Login sekarang</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$check_email = "SELECT email FROM users WHERE email='$email'";
$result = $conn->query($check_email);

if ($result->num_rows > 0) {
    echo "Email sudah digunakan, silakan gunakan email lain.";
} else {
    // Lakukan query INSERT ke database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil. <a href='login.php'>Login sekarang</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>


    
</body>
</html>

