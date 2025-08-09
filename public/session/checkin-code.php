<?php
include('../../includes/database.php');

$num_numbers = intval($_POST['num_numbers']);

for ($i = 0; $i < $num_numbers; $i++) {
    $number = mt_rand(100000, 999999); // Generate random number
    $number = $conn->real_escape_string($number);

    $sql = "INSERT INTO checkin_code (number) VALUES ('$number')";
    $conn->query($sql);
}

echo header('Location: ../admin/attendance.php');
$conn->close();
?>
