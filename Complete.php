<?php
session_start();

if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}

if (!isset($_SESSION['user_data'])) {
    header("Location: CustomerInfo.php");
    exit();
}

$userData = $_SESSION['user_data'];

$contactTimes = isset($_SESSION['contact_times']) ? $_SESSION['contact_times'] : [];
$contactMethod = isset($_SESSION['contact_method']) ? $_SESSION['contact_method'] : "";
$timeSlots = [
    "9am - 10am",
    "10:00am - 11:00am",
    "11:00am - 12:00pm",
    "1:00pm - 2:00pm",
    "2:00pm - 3:00pm",
    "3:00pm - 4:00pm",
    "4:00pm - 5:00pm",
    "5:00pm - 6:00pm",
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Complete</title>
    
    <style>
        body, h1, h2, p {
    margin: 0;
    padding: 0;
}

/* Global styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

header {
    background-color: black;
    color: #fff;
    padding: 10px 0;
    display: flex; /* Use Flexbox to arrange logo and navigation */
    justify-content: flex-start; /* Move the logo closer to "Home" */
    align-items: center; /* Vertically center items */
}

/* Logo styles */
.logo img {
    max-width: 50px; /* Adjust the width as per your preference */
    height: auto; /* This ensures the aspect ratio is maintained */
    margin-right: 10px; /* Add margin to the right of the logo */
}

/* Navigation styles */
nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 30px; /* Reduce the margin here */
}

nav ul li a {
    text-decoration: none;
    color: #fff;
}

/* Container styles */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Heading styles */
h1 {
    color: #008800;
}

/* Form styles */
.form-group {
    margin: 10px 0;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
select,
button,
input[type="submit"],
input[type="button"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px;
}

button,
input[type="submit"],
input[type="button"] {
    background-color: #008800;
    color: #fff;
    cursor: pointer;
}

button:hover,
input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: #006600;
}

/* Error message styles */
.error {
    color: red;
}

    </style>
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="image.jpg" alt="Algonquin College Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Disclaimer.php">Terms and Conditions</a></li>
                <li><a href="CustomerInfo.php">Customer Information</a></li>
                <li><a href="DepositCalculator.php">Calculator</a></li>
                <li><a href="Complete.php">Complete</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Complete</h1>

        <?php if (empty($contactTimes)): ?>
            <div class="complete-message">
                <h2>Thank you, <?= $userData['name'] ? $userData['name'] : 'User' ?>, for using our deposit calculation tool.</h2>
                <p>You did not select any contact times, so we will not be able to call you.</p>
            </div>
        <?php else: ?>
            <div class="complete-message">
                <h2>Thank you, <?= $userData['name'] ? $userData['name'] : 'User' ?>, for using our deposit calculation tool.</h2>
                <?php if ($contactMethod === 'phone'): ?>
                    <p>Our customer service department will contact you via phone at <?= $userData['phoneNumber'] ?> during the following times:</p>
                <?php elseif ($contactMethod === 'email'): ?>
                    <p>Our customer service department will contact you via email at <?= $userData['email'] ?> during the following times:</p>
                <?php endif; ?>
                <ul>
                    <?php foreach ($contactTimes as $index): ?>
                        <?php if (isset($timeSlots[$index])): ?>
                            <li><?= $timeSlots[$index] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            // Clear session data
            session_unset();
            session_destroy();
            ?>
        <?php endif; ?>
    </div>
</body>
</html>