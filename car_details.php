<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vehicle_mgmt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch car details
$car_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($car_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $carResult = $stmt->get_result();

    if ($carResult->num_rows > 0) {
        $car = $carResult->fetch_assoc();
    } else {
        $error = "Car not found.";
    }

    $stmt->close();
} else {
    $error = "Invalid car ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
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

        .car-details {
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .car-details h2 {
            margin-top: 0;
            color: #007BFF;
        }

        .car-details p {
            margin: 0.5em 0;
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
        <h1>Car Details</h1>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="view_cars.php">View Cars</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (isset($car)): ?>
            <div class="car-details">
                <h2><?php echo htmlspecialchars($car['car_name']); ?></h2>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($car['price'], 2)); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($car['description']); ?></p>
                <!-- Add more car details here -->
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Vehicle Transfer Management</p>
    </footer>
</body>
</html>
