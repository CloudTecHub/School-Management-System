<?php 
include('../../includes/database.php');


function getTotalStaffs($conn) {
    $sql = "SELECT COUNT(*) AS total_staffs FROM staff";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_staffs'];
}

?>