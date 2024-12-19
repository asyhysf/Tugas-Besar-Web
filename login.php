<?php
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "tentangsulsel";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa apakah cookie login ada
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        }
    }
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $rememberMe = isset($_POST['remember']);

    // Periksa apakah login menggunakan username atau email
    $query = "SELECT * FROM users WHERE username='$usernameOrEmail' OR email='$usernameOrEmail'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Jika remember me dicentang, set cookie
            if ($rememberMe) {
                setcookie('username', $user['username'], time() + 60, "/"); // 30 hari
                setcookie('password', $password, time() + 60, "/"); // 30 hari
            }

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TentangSulSel</title>
    <link rel="stylesheet" href="assets/styles.css">
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const feedback = document.getElementById('feedback');

            if (username === '' || password === '') {
                feedback.textContent = 'Please fill out all fields.';
                feedback.style.display = 'block';
                return false;
            }

            feedback.style.display = 'none';
            return true;
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <img src="assets/pinisi1.png" alt="Logo">
            <h2>TentangSulSel</h2>
        </div>
        <div class="login-form">
            <h1>Welcome Back!</h1>
            <?php if (!empty($error_message)): ?>
                <div id="server-feedback" style="color: red; margin-bottom: 10px;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div id="feedback" style="color: red; display: none; margin-bottom: 10px;"></div>
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" placeholder="Username or Email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="******" required>

                <div class="form-options">
                    <div class="remember-me"> 
                        <label><input type="checkbox" id="remember" name="remember"> Remember Me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="login-button">Sign In</button>
            </form>
            <p class="center-text">Don't have an account? <a href="signup.php" class="signup-link">Create Account</a></p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 TentangSulSel | All Rights Reserved</p>
    </footer>
</body>
</html>
