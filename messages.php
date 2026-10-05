<?php
session_start();
include "db.php";

// Admin access only
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Fetch contact messages
$sql = "SELECT id, name, email, message, created_at
        FROM contact_messages
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages - SolutionAdda</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #1e293b;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            color: white;
            margin: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            width: 90%;
            margin: 40px auto;
        }

        h1 {
            color: #1e293b;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1e293b;
            color: white;
        }

        tr:hover {
            background: #f8fafc;
        }

        .message {
            max-width: 400px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

<div class="navbar">

    <h2>SolutionAdda Admin</h2>

    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_solutions.php">Solutions</a>
        <a href="manage_users.php">Users</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

<div class="container">

    <h1>Contact Messages</h1>

    <a href="admin_dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>

    <div class="table-container">

        <?php if ($result && $result->num_rows > 0): ?>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $row["id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["email"]); ?>
                        </td>

                        <td class="message">
                            <?php echo htmlspecialchars($row["message"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["created_at"]); ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </table>

        <?php else: ?>

            <div class="empty">
                No contact messages found.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>