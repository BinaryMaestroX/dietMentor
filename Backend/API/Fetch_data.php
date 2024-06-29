<?php
// Database connection parameters
$hostname = 'localhost'; // Replace with your hostname
$username = 'id22385652_admin'; // Replace with your database username
$password = 'Admin@dietmentor0'; // Replace with your database password
$database_name = 'id22385652_dietmentor'; // Replace with your database name

// Create connection
$conn = new mysqli($hostname, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request with username is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username from POST data
    $username = $_POST['username'];

    // Prepare SQL statement to fetch user data
    $sql = "SELECT user_id, username, dob, phone, email FROM Users WHERE username = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_param);

    // Set parameter and execute
    $username_param = $username;
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($user_id, $username, $dob, $phone, $email);

    // Fetch data
    if ($stmt->fetch()) {
        // User found, create array
        $user_data = array(
            "user_id" => $user_id,
            "username" => $username,
            "dob" => $dob,
            "phone" => $phone,
            "email" => $email
        );

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($user_data);
    } else {
        // User not found
        http_response_code(404);
        echo json_encode(array("message" => "User not found."));
    }

    // Close statement
    $stmt->close();
} else {
    // Handle if not a POST request
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}

// Close connection
$conn->close();
?>
