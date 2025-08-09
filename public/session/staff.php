<?php
include('../../includes/database.php');

$gender =  $_REQUEST['gender'];
$first_name =  $_REQUEST['first_name'];
$mid_name =  $_REQUEST['mid_name'];
$last_name =  $_REQUEST['last_name'];
$dob =  $_REQUEST['dob'];
$number =  $_REQUEST['number'];
$email =  $_REQUEST['email'];
//$class =  $_REQUEST['class'];
$healthinsur =  $_REQUEST['healthinsur'];
$curaddress =  $_REQUEST['curaddress'];
$cityname =  $_REQUEST['cityname'];
//$permaddress =  $_REQUEST['permaddresss'];
//$employee_code =  $_REQUEST['employee_code'];
$qualification =  $_REQUEST['qualification'];
$join_date =  $_REQUEST['join_date'];
$curr_position =  $_REQUEST['curr_position'];
$role =  $_REQUEST['role'];
$username =  $_REQUEST['username'];
$password =  $_REQUEST['password'];
$conpassword =  $_REQUEST['conpassword'];
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);
// Function to generate the student ID
function generateStaffID($conn)
{
    // Query to get the last student ID from the database
    $result = $conn->query("SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1");

    if ($result->num_rows > 0) {
        // Fetch the last student ID
        $row = $result->fetch_assoc();
        $lastStaffID = (int)substr($row['staff_id'], 3);  // Extract the number part from 'STFxxxxx'
        $newStaffID = 'STF' . str_pad($lastStaffID + 1, 7, '0', STR_PAD_LEFT); // Increment the ID and pad with leading zeros
    } else {
        // If no student exists, start from STD0000001
        $newStudentID = 'STF0000001';
    }

    return $newStaffID;
}

// Generate the new student ID
$staff_id = generateStaffID($conn);
// Performing insert query execution
$sql = "INSERT INTO staff (staff_id, gender,first_name, mid_name, last_name, dob, number, email,healthinsur, curaddress, cityname,qualification, join_date, curr_position,role,username, password, conpassword )  VALUES ('$staff_id','$gender','$first_name','$mid_name','$last_name',
            '$dob','$number','$email',
            '$healthinsur','$curaddress','$cityname',
            '$qualification','$join_date','$curr_position',
            '$role','$username','$hashPassword', 
            '$hashConPassword')";
if (mysqli_query($conn, $sql)) {
    header("location: ../admin/add-staff.php");
} else {
    echo "ERROR: Hush! Sorry $sql. "
        . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
