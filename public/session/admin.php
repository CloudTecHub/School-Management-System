
<?php


include('../../includes/database.php');

$id = $_POST['administrator_id'];
$name =  $_POST['name'];
$role = $_POST['role'];
$username =  $_POST['username'];
$password = $_POST['password'];
$conpassword = $_POST['conpassword'];
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);
// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO administrator VALUES ('$id','$name', '$role', '$username', 
    '$hashPassword', '$hashConPassword')";

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
