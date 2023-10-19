<?php
session_start();

if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}
$principal = $time = $interestRate = $total = $interest = 0;
$errors = [];

$previousPage = "CustomerInfo.php"; // default previous page

// Check if preferredContact is set and adjust the previous page accordingly
if (isset($_SESSION['user_data']['preferredContact'])) {
    $previousPage = $_SESSION['user_data']['preferredContact'] === "phone" ? "ContactTime.php" : "CustomerInfo.php";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $principal = isset($_POST["principal"]) ? floatval($_POST["principal"]) : 0;
    $time = isset($_POST["time"]) ? intval($_POST["time"]) : 0;

    if ($principal > 0 && $time > 0) {
        $interestRate = 0.03;
        $interest = $principal * $interestRate * $time;
        $total = $principal + $interest;
    } else {
        $errors[] = "Principal amount and time must be greater than 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Calculator</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Add custom styles for the Deposit Calculator page */
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
            width: 100px; /* Adjust the width as needed */
            height: auto; /* Maintain the aspect ratio */
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
            color: lightgray;
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
            border-radius: 10px; /* Add a subtle curve to the container */
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #007B5E; /* Adjust the text color as needed */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px; /* Add a subtle curve to the input fields */
        }

        select {
            appearance: none;
            background: url('arrow-down.png') no-repeat right;
            background-size: 20px;
        }

        input[type="submit"],
        a.button-link {
            background-color: #4682B4;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            border-radius: 5px; /* Add a subtle curve to the button */
        }

        input[type="submit"]:hover,
        a.button-link:hover {
            background-color: #57A0D3;
        }

        .error {
            background-color: #ffcccc;
            padding: 10px;
            border-radius: 5px;
            color: #ff0000;
            font-weight: bold;
        }

        h2 {
            font-size: 20px;
            color: #007B5E;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a.button-link {
            margin-right: 10px; /* Adjust the margin between buttons as needed */
        }

        footer {
            background-color: #007B5E;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
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
        <h1>Deposit Calculator</h1>
        <p>Enter principal amount and select the number of years to deposit.</p>

        <form method="post">
            <!-- Your form fields here -->
            <div class="form-group">
                <label for="principal">Principal Amount:</label>
                <input type="text" id="principal" name="principal" value="<?= htmlspecialchars($principal) ?>">
            </div>

            <div class="form-group">
                <label for="time">Years to Deposit:</label>
                <select id="time" name="time">
                    <option value="">Select...</option>
                    <?php for ($i = 1; $i <= 15; $i++): ?>
                        <option value="<?= $i ?>"<?= $i === $time ? ' selected' : '' ?>><?= $i ?> Years</option>
                    <?php endfor; ?>
                </select>
            </div>

            <input type="submit" value="Calculate">
        </form>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($total > 0): ?>
            <h2>Results of the calculation at the current interest rate of 3%</h2>
            <table>
    <tr>
        <th>Year</th>
        <th>Principal at Year Start</th>
        <th>Interest for the Year</th>
    </tr>
    <?php
    $principalAtYearStart = $principal;
    for ($year = 1; $year <= $time; $year++) {
        $interestYear = $principalAtYearStart * $interestRate;
        $principalAtYearStart += $interestYear;
    ?>
    <tr>
        <td><?= $year ?></td>
        <td>$<?= number_format($principalAtYearStart, 2) ?></td>
        <td>$<?= number_format($interestYear, 2) ?></td>
    </tr>
    <?php } ?>
</table>

        <?php endif; ?>

        <a href="<?= $previousPage ?>"><input type="button" value="Previous"></a>
        <a href="javascript:void(0);" onclick="validateBeforeComplete();"><input type="button" value="Complete"></a>

    </div>
    <footer>&copy; Algonquin College 2010-2023. All Rights Reserved</footer>
    
    <script>
    function validateBeforeComplete() {
        var principal = parseFloat(document.getElementById("principal").value);
        var time = parseInt(document.getElementById("time").value);

        if (principal > 0 && time > 0) {
            window.location.href = "Complete.php"; // Navigate to the complete page
        } else {
            alert("Please enter a valid principal amount and time before completing.");
        }
    }
</script>

</body>
</html>