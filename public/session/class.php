<?php

include('../../includes/database.php');
// Taking all 5 values from the form data(input)
$class_id =  $_POST['class_id'];
$class_name =  $_POST['class_name'];

// Performing insert query execution
$sql = "INSERT INTO class (class_id, class_name) VALUES ('$class_id', '$class_name')";

if (mysqli_query($conn, $sql)) {
    echo "Saved successfully";
    header("location: ../admin/add-class.php");
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
