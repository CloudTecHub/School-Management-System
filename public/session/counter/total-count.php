<?php 
include('../../includes/database.php');

function getUserCountSummary($conn) {
    $sql = "
        SELECT 'STUDENTS' AS user_type, COUNT(*) AS total_users FROM students
        UNION
        SELECT 'STAFFS', COUNT(*) FROM staff
        UNION
        SELECT 'TOTAL', 
            (SELECT COUNT(*) FROM students) + (SELECT COUNT(*) FROM staff)
    ";
    $result = mysqli_query($conn, $sql);
    
    $summary = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $summary[$row['user_type']] = $row['total_users'];
    }
    return $summary;
}

?>
