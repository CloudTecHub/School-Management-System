<?php
include('include/side-bar.php');
include '../../includes/database.php';

// Ensure user is logged in as staff
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location:../../index.php");
    exit();
}

$staff_username = $_SESSION['username'];
$staff_result = $conn->query("SELECT staff_id FROM staff WHERE username = '$staff_username'");
$staff_data = $staff_result->fetch_assoc();
$staff_id = $staff_data['staff_id'];

// Get assigned class
$class_query = $conn->query("
    SELECT c.class_name FROM staff_classes sc 
    JOIN class c ON sc.class_name = c.class_name
    WHERE sc.staff_id = '$staff_id'
");
$class_row = $class_query->fetch_assoc();

if (!$class_row) {
    $error = "No class assigned to you.";
} else {
    $class_name = $class_row['class_name'];

    // Handle filter date or default to today
    $selected_date = $_GET['date'] ?? date('Y-m-d');
    $today = date('Y-m-d');

    // Handle attendance submission (only for today)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selected_date === $today) {
        $marked_students = $_POST['attendance'] ?? [];

        $all_students = $conn->query("SELECT student_id FROM students WHERE class = '$class_name'");
        while ($row = $all_students->fetch_assoc()) {
            $student_id = $row['student_id'];
            $status = in_array($student_id, $marked_students) ? 'present' : 'absent';

            $check = $conn->query("SELECT * FROM attendance WHERE student_id = '$student_id' AND date = '$today'");
            if ($check->num_rows === 0) {
                $conn->query("INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$today', '$status')");
            }
        }

        $success = "Attendance submitted for " . date('F j, Y');
    }

    // Query students and their attendance status for selected date
    $student_query = "
        SELECT s.student_id, s.first_name, s.last_name,
               (
                   SELECT status FROM attendance 
                   WHERE student_id = s.student_id AND date = '$selected_date'
                   LIMIT 1
               ) AS status,
               (
                   SELECT COUNT(*) FROM attendance 
                   WHERE student_id = s.student_id AND status = 'present'
               ) AS days_present
        FROM students s
        WHERE s.class = '$class_name'
    ";
    $students_result = $conn->query($student_query);
}
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Attendance - <?= date('F j, Y', strtotime($selected_date)) ?></h1>

        <!-- Filter Form -->
        <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
            <label for="date" class="text-lg font-medium">Select Date:</label>
            <input type="date" id="date" name="date" value="<?= $selected_date ?>" max="<?= date('Y-m-d') ?>"
                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        </form>

        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                <?= $success ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($error)): ?>
            <form method="POST">
                <?php if ($selected_date === $today): ?>
                    <div class="flex justify-end mb-4 space-x-2">
                        <button type="button" onclick="toggleCheckboxes(true)" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Select All</button>
                        <button type="button" onclick="toggleCheckboxes(false)" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Unselect All</button>
                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto shadow rounded-lg border border-gray-300 dark:border-gray-700">
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">First Name</th>
                                <th class="px-4 py-2 border">Last Name</th>
                                <th class="px-4 py-2 border">
                                    <?= $selected_date === $today ? 'Mark Present' : 'Status' ?>
                                </th>
                                <th class="px-4 py-2 border">Days Present</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($student = $students_result->fetch_assoc()): ?>
                                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 border"><?= $student['student_id'] ?></td>
                                    <td class="px-4 py-2 border"><?= $student['first_name'] ?></td>
                                    <td class="px-4 py-2 border"><?= $student['last_name'] ?></td>
                                    <td class="px-4 py-2 border text-center">
                                        <?php if ($selected_date === $today): ?>
                                            <input type="checkbox" name="attendance[]" value="<?= $student['student_id'] ?>"
                                                class="student-checkbox w-5 h-5"
                                                <?= $student['status'] === 'present' ? 'checked' : '' ?>>
                                        <?php else: ?>
                                            <span class="<?= $student['status'] === 'present' ? 'text-green-600' : 'text-red-600' ?>">
                                                <?= ucfirst($student['status'] ?? 'Not Marked') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2 border text-center"><?= $student['days_present'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($selected_date === $today): ?>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Submit Attendance</button>
                    </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </main>

    <script>
        function toggleCheckboxes(state) {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = state);
        }
    </script>
    </body>

    </html>
    <?php include('include/modals.php'); ?>
    <?php include('include/head.php'); ?>