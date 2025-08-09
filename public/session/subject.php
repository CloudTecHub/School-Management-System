<?php
include('../../includes/database.php');

// $id_num =  $_REQUEST['id_num'];
$subject_id =  $_REQUEST['subject_id'];
$subject_name = $_REQUEST['subject_name'];

// Performing insert query execution
$sql = "INSERT INTO subjects  VALUES ('$subject_id', 
            '$subject_name')";

if (mysqli_query($conn, $sql)) {
    header("location: ../staff/add-subject.php");
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>