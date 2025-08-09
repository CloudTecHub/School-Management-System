<?php
include('include/sidebar.php');
// Database connection
include('../../includes/database.php');

// Check if the staff session is set
if (!isset($_SESSION['staff_id'])) {
    die('You must be logged in to access this page.');
}

// Fetch the staff's class assignment using staff_id from session
$staff_id = $_SESSION['staff_id'];
$query_class = "SELECT class_name FROM class_assignments WHERE staff_id = '$staff_id'";
$result_class = mysqli_query($conn, $query_class);

if ($result_class && mysqli_num_rows($result_class) > 0) {
    $row_class = mysqli_fetch_assoc($result_class);
    $class_name = $row_class['class_name'];

    // Query to get students in the assigned class
    $query_students = "SELECT student_id, first_name, mid_name, last_name, username, email 
                       FROM students WHERE class = '$class_name' ORDER BY first_name";
    $result_students = mysqli_query($conn, $query_students);

    // Get today's date for attendance checking
    $today_date = date('Y-m-d');
} else {
    $class_name = null; // No class found for this staff
    echo "No class assigned for this staff member.";
    exit();
}

// Handle attendance marking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_attendance'])) {
    $attendance_data = $_POST['attendance'];  // Array with student_id => attendance status

    foreach ($attendance_data as $student_id => $status) {
        // Check if attendance for this student already exists for today
        $check_query = "SELECT * FROM attendance WHERE student_id = '$student_id' AND date = '$today_date'";
        $result_check = mysqli_query($conn, $check_query);

        if ($result_check && mysqli_num_rows($result_check) > 0) {
            // If attendance already recorded, update it
            $update_query = "UPDATE attendance SET status = '$status' WHERE student_id = '$student_id' AND date = '$today_date'";
            mysqli_query($conn, $update_query);
        } else {
            // Otherwise, insert new attendance record
            $insert_query = "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$today_date', '$status')";
            mysqli_query($conn, $insert_query);
        }
    }

    // Redirect back to the page after submission to avoid re-posting the form on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div class="container">
            <h2>Students in Your Class: <?php echo htmlspecialchars($class_name ?? 'No Class Assigned'); ?></h2>
            <?php if ($class_name): ?>
                <form method="POST" action="">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Attendance (<?php echo $today_date; ?>)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_students)): ?>
                                <?php
                                // Check if attendance has been recorded for today
                                $student_id = $row['student_id'];
                                $query_attendance = "SELECT status FROM attendance WHERE student_id = '$student_id' AND date = '$today_date'";
                                $result_attendance = mysqli_query($conn, $query_attendance);
                                $attendance_status = 'Not Recorded'; // Default status

                                if ($result_attendance && mysqli_num_rows($result_attendance) > 0) {
                                    $attendance_status = mysqli_fetch_assoc($result_attendance)['status'];
                                }
                                ?>
                                <tr>
                                    <td class='tab-data'><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td class='tab-data'><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name']); ?></td>
                                    <td class='tab-data'><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td class='tab-data'><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <!-- Attendance dropdown to mark attendance -->
                                        <select name="attendance[<?php echo $row['student_id']; ?>]" class="form-control">
                                            <option value="Present" <?php echo $attendance_status == 'Present' ? 'selected' : ''; ?>>Present</option>
                                            <option value="Absent" <?php echo $attendance_status == 'Absent' ? 'selected' : ''; ?>>Absent</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary" name="submit_attendance">Submit Attendance</button>
                </form>
            <?php else: ?>
                <p>No students found for your class.</p>
            <?php endif; ?>
        </div>
</div>

<?php include('include/header.php') ?>