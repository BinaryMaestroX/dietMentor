<?php
header('Content-Type: application/json');

$servername = "localhost";
$db_username = "id22385652_admin";
$db_password = "Admin@dietmentor0";
$database = "id22385652_dietmentor";

$conn = new mysqli($servername, $db_username, $db_password, $database);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$username = $_POST['username'];
$password = $_POST['password'];
$userrole = $_POST['userrole'];

if ($userrole === 'A') {
    $sql = "SELECT * FROM Admin WHERE username = ?";
} else {
    $sql = "SELECT * FROM Users WHERE username = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        echo json_encode(["status" => "success", "message" => "Login successful", "user_id" => $user['user_id']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
