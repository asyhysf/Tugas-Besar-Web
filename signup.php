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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    if ($password === $confirmPassword) {
        // Hash password untuk keamanan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // Default role untuk user baru

        // Simpan ke database
        $query = "INSERT INTO users (username, password, role, email) VALUES ('$username', '$hashedPassword', '$role', '$email')";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>displayError('Error: Unable to register. Please try again.');</script>";
        }
    } else {
        echo "<script>displayError('Passwords do not match.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="assets/styles.css">
    <script>
        // Validasi formulir sign up
        function validateSignUpForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            let errorMessage = '';

            if (username.trim() === '' || email.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
                errorMessage = 'All fields are required.';
            } else {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    errorMessage = 'Invalid email address.';
                } else if (password.length < 6) {
                    errorMessage = 'Password must be at least 6 characters.';
                } else if (password !== confirmPassword) {
                    errorMessage = 'Passwords do not match.';
                }
            }

            if (errorMessage) {
                displayError(errorMessage);
                return false;
            }

            return true;
        }

        function displayError(message) {
            const errorBox = document.getElementById('error-box');
            errorBox.textContent = message;
            errorBox.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.style.borderColor = this.value.trim() === '' ? 'red' : 'green';
                });
            });
        });
    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <img src="assets/pinisi1.png" alt="Logo TentangSulSel">
            <h2>TentangSulSel</h2>
        </div>

        <div class="login-form">
            <h1>Welcome!</h1>
            <div id="error-box" style="display: none; color: red; margin-bottom: 10px;"></div>
            <form action="" method="POST" onsubmit="return validateSignUpForm()">
                <div style="display: flex; gap: 20px;">
                    <div style="width: 50%;">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div style="width: 50%;">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="*****" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="*****" required>

                <button type="submit" class="login-button">Sign Up</button>

                <div class="center-text">
                    Already have an account? <a href="login.php" class="signup-link">Login</a>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 TentangSulSel | All Rights Reserved</p>
    </footer>
</body>
</html>
