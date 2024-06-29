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

// Get diet_id from POST request
$diet_id = $_POST['diet_id'] ?? '';

// Validate diet_id
if (empty($diet_id) || !is_numeric($diet_id)) {
    echo json_encode(["status" => "error", "message" => "Invalid diet ID"]);
    exit;
}

// Prepare SQL statement
$sql = "SELECT * FROM Diets WHERE diet_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $diet_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if diet exists
if ($result->num_rows > 0) {
    $diet = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $diet]);
} else {
    echo json_encode(["status" => "error", "message" => "Diet not found"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
