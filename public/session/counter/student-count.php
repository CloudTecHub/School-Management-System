<?php 
include('../../includes/database.php');


function getTotalStudents($conn) {
    $sql = "SELECT COUNT(*) AS total_students FROM students";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_students'];
}

?>