<?php
session_start();
include "db.php";

// Only logged-in users can view solutions
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT id, title, category, language, description, code
        FROM solutions
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Solutions - SolutionAdda</title>

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

        .back {
            background: white;
            color: #1e3a8a;
            text-decoration: none;
            padding: 9px 16px;
            border-radius: 6px;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }

        .heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .heading h2 {
            color: #1e3a8a;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .heading p {
            color: #666;
        }

        .solutions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .solution-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .solution-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .solution-card h3 {
            color: #1e3a8a;
            margin-top: 0;
        }

        .tag {
            display: inline-block;
            background: #dbeafe;
            color: #1e3a8a;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
            margin-right: 5px;
            margin-bottom: 10px;
        }

        .description {
            color: #555;
            line-height: 1.5;
            min-height: 60px;
        }

        .code-box {
            background: #111827;
            color: #e5e7eb;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            overflow-x: auto;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .no-solutions {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
            color: #666;
        }

        @media (max-width: 900px) {
            .solutions {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .solutions {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">

        <h1>SolutionAdda</h1>

        <a href="customer_dashboard.php" class="back">
            ← Dashboard
        </a>
        
    </div>


    <div class="container">

        <div class="heading">

            <h2>Programming Solutions</h2>

            <p>
                Explore coding solutions, examples and explanations.
            </p>

        </div>


        <?php if ($result->num_rows > 0): ?>

            <div class="solutions">

                <?php while ($solution = $result->fetch_assoc()): ?>

                    <div class="solution-card">

                        <h3>
                            <?php echo htmlspecialchars($solution["title"]); ?>
                        </h3>

                        <span class="tag">
                            <?php echo htmlspecialchars($solution["category"]); ?>
                        </span>

                        <span class="tag">
                            <?php echo htmlspecialchars($solution["language"]); ?>
                        </span>

                        <p class="description">
                            <?php echo htmlspecialchars($solution["description"]); ?>
                        </p>

                        <div class="code-box">
                            <pre><?php echo htmlspecialchars($solution["code"]); ?></pre>
                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <div class="no-solutions">

                <h3>No Solutions Available</h3>

                <p>
                    There are currently no programming solutions in the database.
                </p>

            </div>

        <?php endif; ?>

    </div>

</body>

</html>