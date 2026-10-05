<?php
session_start();
include "db.php";

// Only admin can access this page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Get all users
$sql = "SELECT id, name, email, role, created_at
        FROM users
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users - SolutionAdda</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
        }

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

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .dashboard-btn {
            background: white;
            color: #1e3a8a !important;
            padding: 9px 15px;
            border-radius: 6px;
            font-weight: bold;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 30px;
        }

        .heading {
            margin-bottom: 25px;
        }

        .heading h2 {
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .heading p {
            color: #666;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1e3a8a;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            color: #444;
        }

        tr:hover {
            background: #f8fafc;
        }

        .admin {
            background: #fee2e2;
            color: #b91c1c;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .customer {
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        @media (max-width: 700px) {

            .navbar {
                padding: 15px;
            }

            .navbar h1 {
                font-size: 20px;
            }

            .container {
                padding: 15px;
            }

        }

    </style>

</head>

<body>

    <div class="navbar">

        <h1>SolutionAdda Admin</h1>

        <div>

            <a href="admin_dashboard.php" class="dashboard-btn">
                ← Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </div>


    <div class="container">

        <div class="heading">

            <h2>👥 Manage Users</h2>

            <p>
                View registered users and their account information.
            </p>

        </div>


        <div class="table-container">

            <?php if ($result->num_rows > 0): ?>

                <table>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th>Registered On</th>

                    </tr>


                    <?php while ($user = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo $user["id"]; ?>
                            </td>

                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($user["name"]); ?>
                                </strong>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["email"]); ?>
                            </td>

                            <td>

                                <?php if ($user["role"] === "admin"): ?>

                                    <span class="admin">
                                        Admin
                                    </span>

                                <?php else: ?>

                                    <span class="customer">
                                        Customer
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?php echo htmlspecialchars($user["created_at"]); ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                </table>

            <?php else: ?>

                <div class="empty">

                    <h3>No Users Found</h3>

                    <p>
                        No registered users are available.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>