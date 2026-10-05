<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id, name, email, password, role
            FROM users
            WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

            // Redirect according to user role
            if ($user["role"] === "admin") {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: customer_dashboard.php");
                exit();
            }

        } else {
            $error = "Invalid email or password.";
        }

    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SolutionAdda</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2563eb, #1e3a8a);

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 380px;
            background: white;
            padding: 35px;
            border-radius: 15px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 32px;
        }

        .logo p {
            color: #666;
            margin-top: 5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
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

        .register {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .register a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

    </style>
</head>

<body>

    <div class="login-container">

        <div class="logo">
            <h1>SolutionAdda</h1>
            <p>Learn • Solve • Grow</p>
        </div>

        <h2>Login</h2>

        <?php if ($error !== ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

        <div class="register">
            Don't have an account?
            <a href="register.php">Register</a>
        </div>

    </div>

</body>

</html>