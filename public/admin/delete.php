<?php
// Include database connection
include('../../includes/database.php');

// Function to delete a record from any table
function deleteRecord($conn, $table, $id_column, $id) {
    // Sanitize the id to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    // Create the delete query
    $delete_sql = "DELETE FROM $table WHERE $id_column='$id'";

    // Execute the query
    if (mysqli_query($conn, $delete_sql)) {
        return true;
    } else {
        return false;
    }
}

// Get the table and column information from the URL parameters
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Ensure both table and id are provided
if ($table && $id) {
    switch ($table) {
    //     case 'administrator':
    //         $id_column = 'id';
    //         $redirect_url = 'settings.php';
    //         break;

        case 'students':
            $id_column = 'student_id';
            $redirect_url = 'students.php';
            break;

        case 'staff':
            $id_column = 'staff_id';
            $redirect_url = 'staff.php';
            break;

        case 'checkin_code':
            $id_column = 'id';
            $redirect_url = 'attendance.php';
            break;

        default:
            echo "Invalid table specified.";
            exit();
    }

    // Attempt to delete the record
    if (deleteRecord($conn, $table, $id_column, $id)) {
        header("Location: $redirect_url");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Missing table or id parameter.";
}

// Close the connection
mysqli_close($conn);
?>
