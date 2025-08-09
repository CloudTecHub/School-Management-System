<?php
include('../../includes/database.php');

// Escape user inputs to prevent SQL injection
$staff_id = $conn->real_escape_string($_POST['staff_id']);
$checkin_code = $conn->real_escape_string($_POST['checkin_code']);

// Check if the random number exists and is not used
$sql = "SELECT id FROM checkin_code WHERE number = '$checkin_code' AND is_used = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $number_id = $row['id'];
    // Mark the random number as used
    $update_sql = "UPDATE checkin_code SET is_used = 1 WHERE id = $number_id";
    $conn->query($update_sql);

    // Record attendance
    $insert_sql = "INSERT INTO staff_attendance (staff_id) VALUES ('$staff_id')";
    $conn->query($insert_sql);

    echo "Check-in successful.";
} else {
    echo "Invalid or already used random number.";
}

$conn->close();
?>
