<?php
session_start();
include "db.php";

$error = "";
$success = "";

// Only logged-in users can send messages
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION["name"];
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $message = trim($_POST["message"]);

    if ($message === "") {

        $error = "Please enter your message.";

    } else {

        $sql = "INSERT INTO contact_messages (name, email, message)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Unable to send your message.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us - SolutionAdda</title>

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

        .dashboard {
            background: white;
            color: #1e3a8a !important;
            padding: 9px 15px;
            border-radius: 6px;
            font-weight: bold;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
        }

        .contact-box {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        h2 {
            color: #1e3a8a;
            text-align: center;
            margin-top: 0;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        input {
            background: #f3f4f6;
        }

        textarea {
            min-height: 160px;
            resize: vertical;
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

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 7px;
            text-align: center;
            margin-bottom: 15px;
        }

        .back {
            display: inline-block;
            margin-top: 18px;
            color: #2563eb;
            text-decoration: none;
        }

    </style>

</head>

<body>

    <div class="navbar">

        <h1>SolutionAdda</h1>

        <div>

            <?php if ($_SESSION["role"] === "customer"): ?>

                <a href="customer_dashboard.php" class="dashboard">
                    ← Dashboard
                </a>

            <?php else: ?>

                <a href="admin_dashboard.php" class="dashboard">
                    ← Dashboard
                </a>

            <?php endif; ?>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </div>


    <div class="container">

        <div class="contact-box">

            <h2>📩 Contact Us</h2>

            <p class="subtitle">
                Have a question or suggestion? Send us a message.
            </p>


            <?php if ($success !== ""): ?>

                <div class="success">
                    <?php echo htmlspecialchars($success); ?>
                </div>

            <?php endif; ?>


            <?php if ($error !== ""): ?>

                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <label>Name</label>

                <input
                    type="text"
                    value="<?php echo htmlspecialchars($name); ?>"
                    readonly
                >


                <label>Email</label>

                <input
                    type="email"
                    value="<?php echo htmlspecialchars($email); ?>"
                    readonly
                >


                <label for="message">
                    Message *
                </label>

                <textarea
                    id="message"
                    name="message"
                    placeholder="Write your message here..."
                    required
                ></textarea>


                <button type="submit">
                    Send Message
                </button>

            </form>


            <?php if ($_SESSION["role"] === "customer"): ?>

                <a href="customer_dashboard.php" class="back">
                    ← Back to Dashboard
                </a>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>