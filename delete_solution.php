<?php
session_start();
include "db.php";

// Only admin can delete solutions
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Check solution ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: manage_solutions.php");
    exit();
}

$id = intval($_GET["id"]);

// Delete solution
$stmt = $conn->prepare("DELETE FROM solutions WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: manage_solutions.php?message=deleted");
    exit();
} else {
    $stmt->close();
    die("Unable to delete solution.");
}
?>