<?php
session_start();

// Only logged-in customers can access this page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    header("Location: login.php");
    exit();
}

$name = $_SESSION["name"];
$email = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Dashboard - SolutionAdda</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
        }

        /* NAVBAR */

        .navbar {
            background: #1e3a8a;
            color: white;

            padding: 16px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .logout {
            background: #dc2626;
            color: white;

            text-decoration: none;

            padding: 9px 16px;

            border-radius: 6px;
        }

        .logout:hover {
            background: #b91c1c;
        }

        /* MAIN CONTAINER */

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        /* WELCOME */

        .welcome {
            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow: 0 3px 12px rgba(0,0,0,0.08);

            margin-bottom: 25px;
        }

        .welcome h2 {
            color: #1e3a8a;
            margin-top: 0;
        }

        .welcome p {
            color: #555;
        }

        /* CARDS */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .card {

            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 3px 12px rgba(0,0,0,0.08);

            transition: 0.3s;
        }

        .card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 8px 20px rgba(0,0,0,0.12);
        }

        .card-icon {

            font-size: 40px;

            margin-bottom: 10px;
        }

        .card h3 {

            color: #1e3a8a;

            margin-top: 5px;
        }

        .card p {

            color: #666;

            line-height: 1.5;
        }

        .card a {

            display: inline-block;

            margin-top: 10px;

            background: #2563eb;

            color: white;

            text-decoration: none;

            padding: 10px 16px;

            border-radius: 6px;
        }

        .card a:hover {

            background: #1e3a8a;
        }

        /* PROFILE */

        .profile {

            background: white;

            margin-top: 25px;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 3px 12px rgba(0,0,0,0.08);
        }

        .profile h3 {

            color: #1e3a8a;

            margin-top: 0;
        }

        .profile p {

            margin: 8px 0;

            color: #555;
        }

        /* MOBILE */

        @media (max-width: 800px) {

            .cards {

                grid-template-columns: 1fr;

            }

            .navbar {

                padding: 15px;

            }

            .container {

                padding: 20px;

            }
        }

    </style>

</head>

<body>

<!-- NAVIGATION BAR -->

<div class="navbar">

    <h1>SolutionAdda</h1>

    <a href="logout.php" class="logout">
        Logout
    </a>

</div>


<!-- MAIN CONTENT -->

<div class="container">


    <!-- WELCOME -->

    <div class="welcome">

        <h2>
            Welcome, <?php echo htmlspecialchars($name); ?>! 👋
        </h2>

        <p>
            Welcome to your SolutionAdda customer dashboard.
        </p>

        <p>
            Explore programming solutions, learn new concepts,
            and improve your skills.
        </p>

    </div>


    <!-- DASHBOARD CARDS -->

    <div class="cards">


        <!-- SOLUTIONS -->

        <div class="card">

            <div class="card-icon">
                📚
            </div>

            <h3>
                Browse Solutions
            </h3>

            <p>
                Explore programming solutions,
                examples and useful explanations.
            </p>

            <a href="solutions.php"> View Solutions </a>

        </div>


        <!-- CATEGORIES -->

        <div class="card">

            <div class="card-icon">
                💻
            </div>

            <h3>
                Programming
            </h3>

            <p>
                Explore solutions in different
                programming languages and categories.
            </p>

            <a href="#">
                Explore
            </a>

        </div>


        <!-- CONTACT -->

        <div class="card">

            <div class="card-icon">
                📩
            </div>

            <h3>
                Contact Us
            </h3>

            <p>
                Have a question or suggestion?
                Send a message to SolutionAdda.
            </p>

            <a href="contact.php">
                Contact
            </a>

        </div>

    </div>


    <!-- USER PROFILE -->

    <div class="profile">

        <h3>
            👤 My Account
        </h3>

        <p>
            <strong>Name:</strong>
            <?php echo htmlspecialchars($name); ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?php echo htmlspecialchars($email); ?>
        </p>

        <p>
            <strong>Account Type:</strong>
            Customer
        </p>

    </div>

</div>

</body>

</html>