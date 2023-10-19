<?php
session_start();

// Check if the user has agreed to the terms and conditions
if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}

// Check if the user has agreed to the terms and conditions
if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}

// Initialize variables and errors array
$name = $postalCode = $phoneNumber = $email = $preferredContact = "";
$errors = [];

// Check and preserve user data for back-and-forth navigation
if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];
    $name = $user_data['name'];
    $postalCode = $user_data['postalCode'];
    $phoneNumber = $user_data['phoneNumber'];
    $email = $user_data['email'];
    $preferredContact = $user_data['preferredContact'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $postalCode = $_POST["postalCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $preferredContact = isset($_POST["preferredContact"]) ? $_POST["preferredContact"] : "";

    // Perform data validation
    if (empty($name)) {
        $errors["name"] = "Name is required.";
    }

    // Postal code validation
    if (!preg_match("/^[A-Za-z]\d[A-Za-z] ?\d[A-Za-z]\d$/", $postalCode)) {
        $errors["postalCode"] = "Incorrect Postal Code";
    }

    // Phone number validation
    if (!preg_match("/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/", $phoneNumber)) {
        $errors["phoneNumber"] = "Incorrect Phone Number";
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Incorrect Email Address";
    }

    if (empty($preferredContact)) {
        $errors["preferredContact"] = "Contact method is required";
    }

    // If no errors, proceed to the next page
    if (empty($errors)) {
        // Save user data in session
        $_SESSION['user_data'] = [
            'name' => $name,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'email' => $email,
            'preferredContact' => $preferredContact,
        ];

        header("Location: ContactTime.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        /* Add custom styles for the Customer Information page */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .logo img {
            width: 100px; 
            height: auto; 
        }

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav li {
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color:lightgray;
            font-weight: bold;
        }

        nav a:hover {
            color: #f5f5f5;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px; 
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #007B5E; /* Adjust the text color as needed */
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px; /* Add a subtle curve to the input fields */
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            background-color: #4682B4;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            border-radius: 5px; /* Add a subtle curve to the button */
        }

        button:hover {
            background-color: #57A0D3;
        }

        .error-message {
            color: red;
        }

        footer {
    background-color: darkgreen;
    color: white;
    padding: 15px;
    text-align: center;
    position: absolute;
    bottom: 0;
    width: 100%;
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
    
    <h1>Customer Information</h1>
    <form method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?= $name ?>">
            <?php if (isset($errors["name"])) : ?>
                <div style="color: red;"><?= $errors["name"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="postalCode">Postal Code:</label>
            <input type="text" name="postalCode" value="<?= $postalCode ?>">
            <?php if (isset($errors["postalCode"])) : ?>
                <div style="color: red;"><?= $errors["postalCode"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" value="<?= $phoneNumber ?>" placeholder="(nnn-nnn-nnnn)">
            <?php if (isset($errors["phoneNumber"])) : ?>
                <div style="color: red;"><?= $errors["phoneNumber"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" name="email" value="<?= $email ?>">
            <?php if (isset($errors["email"])) : ?>
                <div style="color: red;"><?= $errors["email"] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label>Preferred Contact Method:</label>
            <input type="radio" name="preferredContact" value="phone" <?= $preferredContact === "phone" ? 'checked' : '' ?>> Phone
            <input type="radio" name="preferredContact" value="email" <?= $preferredContact === "email" ? 'checked' : '' ?>> Email
            <?php if (isset($errors["preferredContact"])) : ?>
                <div style="color: red;"><?= $errors["preferredContact"] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">Next</button>
    </form>
</body>
</html>