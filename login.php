<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
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
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        .login-container .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-container .register-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function showError(message) {
            alert(message);
        }
    </script>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Register</a></p>
        </div>
    </div>

    <?php
    session_start();

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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query untuk mengambil data pengguna berdasarkan email
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                echo "<script>alert('Login berhasil! Selamat datang, " . $user['name'] . "'); window.location.href='index.php';</script>";
            } else {
                echo "<script>showError('Password salah.');</script>";
            }
        } else {
            echo "<script>showError('Email tidak ditemukan.');</script>";
        }
    }

    // Tutup koneksi
    $conn->close();
    ?>

</body>
</html>
