<?php
session_start();

// Check if user is logged in and is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] == 1) {
    header("Location: index.php"); // Redirect to login if not a regular user
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vehicle_mgmt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user-specific data
$carsQuery = "SELECT * FROM cars"; // Modify as needed to show user-specific data
$carsResult = $conn->query($carsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 1em;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            padding: 2em;
        }

        section {
            margin-bottom: 2em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            padding: 1em;
        }

        td {
            padding: 1em;
            text-align: left;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="view_cars.php">View Cars</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="view-cars">
            <h2>Available Cars</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Car Name</th>
                    <th>Price</th>
                </tr>
                <?php if ($carsResult->num_rows > 0): ?>
                    <?php while($row = $carsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['car_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No cars available</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Vehicle Transfer Management</p>
    </footer>
</body>
</html>
