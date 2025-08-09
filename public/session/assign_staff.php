<?php
include(".../../includes/database.php");
error_reporting(0);
@ini_set('display_error', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
$staff_id = $_REQUEST['staff_id'];
$class_name = $_REQUEST['classame'];
// Insert into staff_classes
$sql_insert = "INSERT INTO staff_classes (staff_id, class_name) VALUES ('$staff_id', '$class_name')";
if (mysqli_query($conn, $sql_insert)) {
  // If insert is successful, update the staff table
  $sql_update = "UPDATE staff SET class = '$class_name' WHERE staff_id = '$staff_id'";
//   if (mysqli_query($conn, $sql_update)) {
//     echo "Saved successfully";
//   } else {
//     echo "ERROR updating staff: " . mysqli_error($conn);
//   }
// } else {
//   echo "ERROR inserting staff_classes: " . mysqli_error($conn);
}

?>