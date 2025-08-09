<?php

include('../../includes/database.php');
// Taking all 5 values from the form data(input)
$plan =  $_POST['plan'];
$date =  $_POST['date'];
// Performing insert query execution
$sql = "INSERT INTO term_plan (plan, date) VALUES ('$plan','$date')";

if (mysqli_query($conn, $sql)) {
    echo "Saved successfully";
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>