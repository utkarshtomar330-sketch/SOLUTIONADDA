<?php
session_start();
include "db.php";

// Only admin can access this page
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

// Get solution ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: manage_solutions.php");
    exit();
}

$id = intval($_GET["id"]);

// Get existing solution
$stmt = $conn->prepare(
    "SELECT title, category, language, description, code
     FROM solutions
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    header("Location: manage_solutions.php");
    exit();
}

$solution = $result->fetch_assoc();
$stmt->close();


// Update solution
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $category = trim($_POST["category"]);
    $language = trim($_POST["language"]);
    $description = trim($_POST["description"]);
    $code = trim($_POST["code"]);

    if ($title === "" || $category === "" || $language === "" || $code === "") {

        $error = "Please fill in all required fields.";

    } else {

        $update = $conn->prepare(
            "UPDATE solutions
             SET title = ?, category = ?, language = ?, description = ?, code = ?
             WHERE id = ?"
        );

        $update->bind_param(
            "sssssi",
            $title,
            $category,
            $language,
            $description,
            $code,
            $id
        );

        if ($update->execute()) {

            $success = "Solution updated successfully!";

            // Update displayed values
            $solution["title"] = $title;
            $solution["category"] = $category;
            $solution["language"] = $language;
            $solution["description"] = $description;
            $solution["code"] = $code;

        } else {

            $error = "Failed to update solution.";

        }

        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Solution - SolutionAdda</title>

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

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        h2 {
            color: #1e3a8a;
            text-align: center;
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        .description {
            min-height: 100px;
        }

        .code {
            min-height: 220px;
            font-family: Consolas, monospace;
        }

        .btn {
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

        .btn:hover {
            background: #1e3a8a;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 15px;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 15px;
            text-align: center;
        }

    </style>

</head>

<body>

    <div class="navbar">

        <h1>SolutionAdda Admin</h1>

        <div>

            <a href="admin_dashboard.php">
                Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </div>


    <div class="container">

        <div class="form-box">

            <h2>✏️ Edit Solution</h2>

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

                <label for="title">
                    Solution Title *
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo htmlspecialchars($solution["title"]); ?>"
                    required
                >


                <label for="category">
                    Category *
                </label>

                <input
                    type="text"
                    id="category"
                    name="category"
                    value="<?php echo htmlspecialchars($solution["category"]); ?>"
                    required
                >


                <label for="language">
                    Programming Language *
                </label>

                <select
                    id="language"
                    name="language"
                    required
                >

                    <?php
                    $languages = [
                        "Python",
                        "PHP",
                        "Java",
                        "C",
                        "C++",
                        "JavaScript",
                        "HTML",
                        "CSS",
                        "SQL"
                    ];

                    foreach ($languages as $lang):
                    ?>

                        <option
                            value="<?php echo $lang; ?>"
                            <?php
                            if ($solution["language"] === $lang) {
                                echo "selected";
                            }
                            ?>
                        >
                            <?php echo $lang; ?>
                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="description"
                ><?php echo htmlspecialchars($solution["description"]); ?></textarea>


                <label for="code">
                    Code *
                </label>

                <textarea
                    id="code"
                    name="code"
                    class="code"
                    required
                ><?php echo htmlspecialchars($solution["code"]); ?></textarea>


                <button type="submit" class="btn">
                    Update Solution
                </button>

            </form>


            <a href="manage_solutions.php" class="back">
                ← Back to Manage Solutions
            </a>

        </div>

    </div>

</body>

</html>