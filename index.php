<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "vehicle_mgmt"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration logic
if (isset($_POST['register'])) {
    $reg_username = $_POST['reg_username'];
    $reg_email = $_POST['reg_email'];
    $reg_password = password_hash($_POST['reg_password'], PASSWORD_BCRYPT);
    $role_id = 2; // Default role is 'User'

    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $reg_username, $reg_email, $reg_password, $role_id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=registered");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Login logic
if (isset($_POST['login'])) {
    $log_username = $_POST['log_username'];
    $log_password = $_POST['log_password'];

    $stmt = $conn->prepare("SELECT id, password_hash, role_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $log_username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $password_hash, $role_id);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($log_password, $password_hash)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role_id'] = $role_id;

            if ($role_id == 1) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .msg {
            text-align: center;
            color: green;
        }

        .toggle-form {
            text-align: center;
            margin-top: 20px;
        }

        .toggle-form a {
            color: #007BFF;
            text-decoration: none;
        }

        .toggle-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'registered'): ?>
        <p class="msg">Registration successful! Please log in.</p>
    <?php endif; ?>

    <h2 id="form-title">Login</h2>

    <!-- Login Form -->
    <form id="login-form" method="post" action="index.php">
        <input type="text" name="log_username" placeholder="Username" required><br>
        <input type="password" name="log_password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <!-- Registration Form -->
    <form id="register-form" method="post" action="index.php" style="display:none;">
        <input type="text" name="reg_username" placeholder="Username" required><br>
        <input type="email" name="reg_email" placeholder="Email" required><br>
        <input type="password" name="reg_password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

    <div class="toggle-form">
        <a href="javascript:void(0);" id="toggle-link">Don't have an account? Register</a>
    </div>
</div>

<script>
    // Toggle between login and registration forms
    const toggleLink = document.getElementById('toggle-link');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formTitle = document.getElementById('form-title');

    toggleLink.addEventListener('click', function () {
        if (registerForm.style.display === 'none') {
            registerForm.style.display = 'block';
            loginForm.style.display = 'none';
            formTitle.textContent = 'Register';
            toggleLink.textContent = 'Already have an account? Login';
        } else {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
            formTitle.textContent = 'Login';
            toggleLink.textContent = "Don't have an account? Register";
        }
    });
</script>

</body>
</html>
