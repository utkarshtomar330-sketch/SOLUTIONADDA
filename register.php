<?php
session_start();
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "An account with this email already exists.";

        } else {

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // New users are customers
            $role = "customer";

            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashedPassword,
                $role
            );

            if ($stmt->execute()) {

                $success = "Registration successful! You can now login.";
                

            } else {

                $error = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - SolutionAdda</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1e3a8a
            );

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {

            width: 400px;

            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow:
                0 10px 30px rgba(0,0,0,0.25);
        }

        .logo {
            text-align: center;
        }

        .logo h1 {
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .logo p {
            color: #666;
        }

        h2 {
            text-align: center;
            color: #333;

            margin-bottom: 25px;
        }

        label {
            display: block;

            margin-top: 14px;
            margin-bottom: 6px;

            font-weight: bold;
        }

        input {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 7px;

            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {

            width: 100%;

            margin-top: 25px;

            padding: 13px;

            background: #2563eb;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        button:hover {
            background: #1e3a8a;
        }

        .error {

            background: #fee2e2;

            color: #b91c1c;

            padding: 10px;

            border-radius: 6px;

            text-align: center;

            margin-bottom: 15px;
        }

        .success {

            background: #dcfce7;

            color: #166534;

            padding: 10px;

            border-radius: 6px;

            text-align: center;

            margin-bottom: 15px;
        }

        .login {

            text-align: center;

            margin-top: 20px;

            color: #666;
        }

        .login a {

            color: #2563eb;

            text-decoration: none;

            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="register-container">

    <div class="logo">

        <h1>SolutionAdda</h1>

        <p>Learn • Solve • Grow</p>

    </div>

    <h2>Create Account</h2>

    <?php if ($error !== ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <?php if ($success !== ""): ?>

        <div class="success">
            <?php echo htmlspecialchars($success); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            placeholder="Enter your name"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Create a password"
            required
        >

        <label>Confirm Password</label>

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm your password"
            required
        >

        <button type="submit">
            Create Account
        </button>

    </form>

    <div class="login">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>

</html>