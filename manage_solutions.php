<?php
session_start();
include "db.php";

// Only admin can access this page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Get all solutions
$sql = "SELECT id, title, category, language, description, code, created_at
        FROM solutions
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Solutions - SolutionAdda</title>

    <a href="admin_dashboard.php"> ← Dashboard </a>
    <a href="add_solution.php"> + Add Solution </a>
    <a href="edit_solution.php?id=<?php echo $solution["id"]; ?>"> Edit </a>
    <a href="delete_solution.php?id=<?php echo $solution["id"]; ?>">  Delete </a>
    <a href="logout.php"> Logout </a>

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
            margin-left: 10px;
        }

        .dashboard-btn {
            background: white;
            color: #1e3a8a !important;
            padding: 9px 15px;
            border-radius: 6px;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h2 {
            color: #1e3a8a;
            margin: 0;
        }

        .add-btn {
            background: #16a34a;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 6px;
            font-weight: bold;
        }

        .add-btn:hover {
            background: #15803d;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
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
            padding: 13px;
            text-align: left;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            color: #444;
            vertical-align: top;
        }

        tr:hover {
            background: #f8fafc;
        }

        .tag {
            display: inline-block;
            background: #dbeafe;
            color: #1e3a8a;
            padding: 5px 9px;
            border-radius: 15px;
            font-size: 13px;
        }

        .code {
            background: #111827;
            color: #e5e7eb;
            padding: 10px;
            border-radius: 6px;
            max-width: 300px;
            overflow-x: auto;
        }

        .code pre {
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .edit-btn {
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 7px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .delete-btn {
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 7px 12px;
            border-radius: 5px;
            display: inline-block;
        }

        .edit-btn:hover {
            background: #1d4ed8;
        }

        .delete-btn:hover {
            background: #b91c1c;
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

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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

        <div class="header">

            <h2>Manage Solutions</h2>

            <a href="add_solution.php" class="add-btn">
                + Add Solution
            </a>

        </div>


        <div class="table-container">

            <?php if ($result->num_rows > 0): ?>

                <table>

                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Language</th>
                        <th>Description</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>

                    <?php while ($solution = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo $solution["id"]; ?>
                            </td>

                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($solution["title"]); ?>
                                </strong>
                            </td>

                            <td>
                                <span class="tag">
                                    <?php echo htmlspecialchars($solution["category"]); ?>
                                </span>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($solution["language"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($solution["description"]); ?>
                            </td>

                            <td>

                                <div class="code">
                                    <pre><?php echo htmlspecialchars($solution["code"]); ?></pre>
                                </div>

                            </td>

                            <td>

                                <a
                                    href="edit_solution.php?id=<?php echo $solution["id"]; ?>"
                                    class="edit-btn">
                                    Edit
                                </a>

                                <br>

                                <a
                                    href="delete_solution.php?id=<?php echo $solution["id"]; ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this solution?');">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </table>

            <?php else: ?>

                <div class="empty">

                    <h3>No Solutions Found</h3>

                    <p>
                        Click "Add Solution" to create your first programming solution.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>