<?php
// Database connection
require_once('../../../includes/database.php');
// Delete record
$id = $_GET['id'];
$delete_sql = "DELETE FROM staff_attendance WHERE id='$id'";

if (mysqli_query($conn, $delete_sql)) {
    header("Location: check-in.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
