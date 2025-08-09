<?php
include('include/sidebar.php');
// Database connection
include('../../includes/database.php');

// Fetch the staff's class assignment using staff_id from session
$staff_id = $_SESSION['staff_id'];
$query_class = "SELECT class_name FROM class_assignments WHERE staff_id = ?";
$stmt = $conn->prepare($query_class);
$stmt->bind_param("s", $staff_id);
$stmt->execute();
$result_class = $stmt->get_result();

if ($result_class->num_rows > 0) {
  $row_class = $result_class->fetch_assoc();
  $class_name = $row_class['class_name'];

  // Query to get students in the assigned class
  $query_students = "SELECT student_id, first_name, mid_name, last_name, username, email 
                       FROM students WHERE class = ? ORDER BY first_name";
  $stmt_students = $conn->prepare($query_students);
  $stmt_students->bind_param("s", $class_name);
  $stmt_students->execute();
  $result_students = $stmt_students->get_result();
} else {
  $class_name = null; // No class found for this staff
}

?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
    <div class="container">
      <h2>Students in Your Class: <?php echo htmlspecialchars($class_name ?? 'No Class Assigned'); ?></h2>
      <?php if ($class_name): ?>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Full Name</th>
              <th>Username</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result_students->fetch_assoc()): ?>
              <tr>
                <td class='tab-data'><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td class='tab-data'><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name']); ?></td>
                <td class='tab-data'><?php echo htmlspecialchars($row['username']); ?></td>
                <td class='tab-data'><?php echo htmlspecialchars($row['email']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No students found for your class.</p>
      <?php endif; ?>
    </div>
    <?php
    include('include/header.php')
    ?>