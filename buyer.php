<?php
    // Establishing a connection to the database
    $d = mysqli_connect('localhost', 'root', '', 'revision300');
    
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieving form data
        $fullname = mysqli_real_escape_string($d, $_POST['fullname']);
        $email = mysqli_real_escape_string($d, $_POST['email']);
        $phone = mysqli_real_escape_string($d, $_POST['phone']);
        $message = mysqli_real_escape_string($d, $_POST['message']);

        // SQL query to insert data into the 'Contact Us' table
        $sql = "INSERT INTO `Contact Us` (fullname, email, phone, message) VALUES ('$fullname', '$email', '$phone', '$message')";
        
        // Executing the query
        $result = mysqli_query($d, $sql);
        
        // Checking if the data was successfully inserted
        if ($result) {
            echo "Successfully Saved";
        } else {
            echo "Data not saved";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Vehicle Transfer Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #0056b3;
        }
        .nav-link {
            display: block;
            margin: 20px 0;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-size: 1.1em;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Contact Us</h1>
    
    <!-- Contact Form -->
    <form method="post" id="contact-form">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone">

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit" name="submit">Send</button>
    </form>

    <a href="car listings.html" class="nav-link">Go to Car Listings Page</a>
</div>

<script>
    // Extract query parameters from URL
    const urlParams = new URLSearchParams(window.location.search);
    const model = urlParams.get('model');
    const make = urlParams.get('make');

    // Update form or page with car details if available
    if (model && make) {
        document.querySelector('h1').textContent = `Contact Us about ${make} ${model}`;
    }

    document.getElementById('contact-form').addEventListener('submit', function(event) {
        // Uncomment the following line if you want to prevent the form from submitting to the server
        // event.preventDefault(); 
        
        alert('Thank you for your inquiry! We will get back to you soon.');
    });
</script>

</body>
</html>
