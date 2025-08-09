
<?php
include('../../includes/database.php');

// Get the other form data
$gender = $_REQUEST['gender'];
$first_name = $_REQUEST['first_name'];
$mid_name = $_REQUEST['mid_name'];
$last_name = $_REQUEST['last_name'];
$dob = $_REQUEST['dob'];
$number = $_REQUEST['number'];
$email = $_REQUEST['email'];
$class = $_REQUEST['class'];
$healthinsur = $_REQUEST['healthinsur'];
$curaddress = $_REQUEST['curaddress'];
$cityname = $_REQUEST['cityname'];
//$permaddresss = $_REQUEST['permaddresss'];
$parent_first_name = $_REQUEST['parent_first_name'];
$parent_mid_name = $_REQUEST['parent_mid_name'];
$parent_last_name = $_REQUEST['parent_last_name'];
$parent_email = $_REQUEST['parent_email'];
$parent_number = $_REQUEST['parent_number'];
//$profession = $_REQUEST['profession'];
$role = $_REQUEST['role'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$conpassword = $_REQUEST['conpassword'];
$hashPassword = password_hash($password, PASSWORD_BCRYPT);
$hashConPassword = password_hash($conpassword, PASSWORD_BCRYPT);

// Function to generate the student ID
function generateStudentID($conn) {
    // Query to get the last student ID from the database
    $result = $conn->query("SELECT student_id FROM students ORDER BY student_id DESC LIMIT 1");
    
    if ($result->num_rows > 0) {
        // Fetch the last student ID
        $row = $result->fetch_assoc();
        $lastStudentID = (int)substr($row['student_id'], 3);  // Extract the number part from 'STDxxxxx'
        $newStudentID = 'STD' . str_pad($lastStudentID + 1, 7, '0', STR_PAD_LEFT); // Increment the ID and pad with leading zeros
    } else {
        // If no student exists, start from STD0000001
        $newStudentID = 'STD0000001';
    }

    return $newStudentID;
}

// Generate the new student ID
$student_id = generateStudentID($conn);

// Performing insert query execution
$sql = "INSERT INTO students (student_id, gender, first_name, mid_name, last_name, dob, number, email, class, healthinsur, curaddress, cityname, parent_first_name, parent_mid_name, parent_last_name, parent_email, parent_number, role, username, password, conpassword) 
        VALUES ('$student_id', '$gender', '$first_name', '$mid_name', '$last_name', '$dob', '$number', '$email', '$class', '$healthinsur', '$curaddress', '$cityname',  '$parent_first_name', '$parent_mid_name', '$parent_last_name', '$parent_email', '$parent_number', '$role', '$username', '$hashPassword','$hashConPassword')";

if (mysqli_query($conn, $sql)) {
    header("location: ../admin/add-student.php");
} else {
    echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>

?>
