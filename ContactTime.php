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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contactTimes = isset($_POST["contactTimes"]) ? $_POST["contactTimes"] : [];

    if (empty($contactTimes)) {
        $contactTimesError = "You must select contact times for us to call you";
    } else {
        $_SESSION['contact_times'] = $contactTimes;
        $_SESSION['contact_method'] = $userData['preferredContact'];
        header("Location: DepositCalculator.php");
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
    <title>Select Contact Time</title>
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
     font-size: 30px;
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
    
    padding-left: 20px;
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
    background-color: #4682B4;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            border-radius: 5px; /* Add a subtle curve to the button */
}

button,
input[type="submit"],
input[type="button"] {
    background-color: #4682B4;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover,
input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: #57A0D3;
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
    <h1>Select Contact Time</h1>
    <form method="post">
        <div>
            <p>When can we contact you? Check all applicable:</p>
            <?php
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

            foreach ($timeSlots as $index => $slot) {
                $isChecked = in_array($index, $contactTimes) ? 'checked' : '';
                echo "<label><input type='checkbox' name='contactTimes[]' value='$index' $isChecked>$slot</label><br>";
            }
            ?>
            <?php if (isset($contactTimesError)): ?>
                <p style="color: red;"><?php echo $contactTimesError; ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" style="padding: 0px 8px; background-color: #007B5E; color: #fff; border: none; cursor: pointer;">Next</button>
    </form>
    <a href="CustomerInfo.php" style="display: inline-block; padding: 3px 5px; background-color: #007B5E; color: #fff; text-decoration: none; border: none; cursor: pointer;">Back</a>
</body>
</html>