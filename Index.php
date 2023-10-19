<?php
session_start();

$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page != "Disclaimer.php" && $current_page != "index.php" && !isset($_SESSION['agreed_to_terms'])) {
    header("Location: Disclaimer.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Algonquin Bank</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    
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
    text-align: center;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: #fff;
    
}

.container {
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    padding-bottom: 60px;
    flex: 1; /* Allow the container to grow and take up all available space */
    max-width: none; /* Remove the max-width constraint */
    margin: 0; /* Reset margin to remove any default margin */
}

h1 {
    color: black;
    
    text-align: center;
    margin-bottom: 20px;
}
p {
    text-align: center;
}


.form-group {
    margin: 10px 0;
}

label {
    display: block;
    font-weight: bold;
}
.calculator-link {
    text-align: center;
    margin-top: 20px;
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
    transition: background-color 0.3s;
}

button:hover,
input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: #006600;
}

.error {
    color: red;
}

footer {
    background-color: darkgreen;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.container {
    flex: 1;
}

.logo img {
    width: 100px;
    height: auto;
    margin-right: 20px;
}

    </style>
</head>
<body>
    <header>
       <div class="logo">
            <img src="image.jpg" alt=""/>
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
    <h1>Welcome to Algonquin Bank</h1>
    <p>Algonquin Bank is Algonquin College students' most loved bank. We provide a set of tools for Algonquin College students to manage their finance.</p>
    <div class="calculator-link">
        <a href="Disclaimer.php">Deposit Calculator</a>
    </div>
</div>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
</body>
</html>