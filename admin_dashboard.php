<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

$name = $_SESSION["name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - SolutionAdda</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .navbar {
            background: #1e293b;
            color: white;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            margin-top: 0;
            color: #1e293b;
        }

        .welcome p {
            color: #64748b;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card h2 {
            color: #1e293b;
            margin-top: 0;
        }

        .card p {
            color: #64748b;
            min-height: 45px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 6px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .logout {
            background: #dc2626;
            padding: 8px 14px;
            border-radius: 6px;
        }

        .logout:hover {
            background: #b91c1c;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="navbar">

        <h2>SolutionAdda</h2>

        <div>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="manage_solutions.php">Solutions</a>
            <a href="manage_users.php">Users</a>
            <a href="messages.php">Messages</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>

    </div>

    <div class="container">

        <div class="welcome">
            <h1>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h1>
            <p>You are logged in as an administrator of SolutionAdda.</p>
        </div>

        <div class="cards">

            <!-- Manage Solutions -->
            <div class="card">
                <h2>💻 Solutions</h2>

                <p>
                    Add, edit, delete and manage programming solutions.
                </p>

                <a href="manage_solutions.php" class="btn">
                    Manage Solutions
                </a>
            </div>

            <!-- Add Solution -->
            <div class="card">
                <h2>➕ Add Solution</h2>

                <p>
                    Add a new programming solution to SolutionAdda.
                </p>

                <a href="add_solution.php" class="btn">
                    Add Solution
                </a>
            </div>

            <!-- Users -->
            <div class="card">
                <h2>👥 Users</h2>

                <p>
                    View registered customers and administrators.
                </p>

                <a href="manage_users.php" class="btn">
                    Manage Users
                </a>
            </div>

            <!-- Messages -->
            <div class="card">
                <h2>📩 Messages</h2>

                <p>
                    Read messages submitted through the Contact Us page.
                </p>

                <a href="messages.php" class="btn">
                    View Messages
                </a>
            </div>

        </div>

    </div>

</body>
</html>