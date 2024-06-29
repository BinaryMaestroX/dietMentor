<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$db_username = "id22385652_admin";
$db_password = "Admin@dietmentor0";
$database = "id22385652_dietmentor";

// Connect to the database
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

// Get POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$dob = $_POST['dob'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';

// Validate inputs (basic validation example)
if (empty($username) || empty($password) || empty($dob) || empty($phone) || empty($email)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Check if username or email already exists
$sql = "SELECT * FROM Users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Username or email already exists"]);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$sql = "INSERT INTO Users (username, password, dob, phone, email) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $username, $hashed_password, $dob, $phone, $email);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registration successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
