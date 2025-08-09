<?php

include('../../includes/database.php');

// Taking all 5 values from the form data(input)
$image =  $_POST['image'];
$school_name =  $_POST['school_name'];
$type_of_institution = $_POST['type_of_institution'];
$address =  $_POST['address'];
$enrollment_capacity =  $_POST['enrollment_capacity'];
$facilities = $_POST['facilities'];
$email =  $_POST['email'];
$contact =  $_POST['contact'];
$academic_year = $_POST['academic_year'];


// Performing insert query execution
$sql = "INSERT INTO school_details VALUES ('$image','$school_name', 
    '$type_of_institution','$address','$enrollment_capacity', 
    '$facilities','$email','$contact', 
    '$academic_year')";

if (mysqli_query($conn, $sql)) {
    echo "Saved successfully";
    header("location: ../admin/settings.php");
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
