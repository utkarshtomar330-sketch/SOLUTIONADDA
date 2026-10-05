<?php

include "db.php";

$name = "Admin";
$email = "admin@solutionadda.com";
$password = "Admin@123";
$role = "admin";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Admin account created successfully!<br>";
    echo "Email: " . $email . "<br>";
    echo "Password: " . $password;
} else {
    echo "Error: " . $stmt->error;
}

?>