<?php
include('include/side-bar.php');
include '../../includes/database.php';

// Ensure user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
    header("Location:../../index.php");
    exit();
}

// Handle date filter
$selected_date = $_GET['date'] ?? date('Y-m-d');
$class_filter = $_GET['class'] ?? 'all';

// Get all classes for dropdown
$classes = $conn->query("SELECT class_name FROM class");
?>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen flex">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Attendance Overview</h1>

            <!-- Filter Form -->
            <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="date" class="text-lg font-medium">Date:</label>
                    <input type="date" id="date" name="date" value="<?= $selected_date ?>"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                </div>

                <div class="flex items-center gap-2">
                    <label for="class" class="text-lg font-medium">Class:</label>
                    <select id="class" name="class" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring focus:ring-blue-400 dark:bg-gray-800 dark:text-white">
                        <option value="all">All Classes</option>
                        <?php while ($class = $classes->fetch_assoc()): ?>
                            <option value="<?= $class['class_name'] ?>" <?= $class_filter === $class['class_name'] ? 'selected' : '' ?>>
                                <?= $class['class_name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
            </form>

            <!-- Attendance Summary -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Summary for <?= date('F j, Y', strtotime($selected_date)) ?></h2>
                <?php
                // Get summary data
                $summary_query = "
            SELECT 
                c.class_name,
                COUNT(s.student_id) AS total_students,
                SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS present_count,
                ROUND(SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(s.student_id) * 100, 1) AS attendance_percentage
            FROM class c
            LEFT JOIN students s ON c.class_name = s.class
            LEFT JOIN attendance a ON s.student_id = a.student_id AND a.date = '$selected_date'
            WHERE ('$class_filter' = 'all' OR c.class_name = '$class_filter')
            GROUP BY c.class_name
            ORDER BY c.class_name
        ";
                $summary_result = $conn->query($summary_query);
                ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php while ($summary = $summary_result->fetch_assoc()): ?>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-300 dark:border-gray-700">
                            <h3 class="text-lg font-medium mb-2"><?= $summary['class_name'] ?></h3>
                            <p>Total Students: <?= $summary['total_students'] ?></p>
                            <p>Present: <?= $summary['present_count'] ?></p>
                            <p>Absent: <?= $summary['total_students'] - $summary['present_count'] ?></p>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full"
                                        style="width: <?= $summary['attendance_percentage'] ?>%"></div>
                                </div>
                                <p class="text-sm mt-1"><?= $summary['attendance_percentage'] ?>% Attendance</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Detailed Attendance Table -->
            <div class="overflow-x-auto shadow rounded-lg border border-gray-300 dark:border-gray-700">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 border">Class</th>
                            <th class="px-4 py-2 border">Student ID</th>
                            <th class="px-4 py-2 border">First Name</th>
                            <th class="px-4 py-2 border">Last Name</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Days Present</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get detailed attendance data
                        $attendance_query = "
                    SELECT 
                        c.class_name,
                        s.student_id,
                        s.first_name,
                        s.last_name,
                        a.status,
                        (
                            SELECT COUNT(*) FROM attendance 
                            WHERE student_id = s.student_id AND status = 'present'
                        ) AS days_present
                    FROM students s
                    JOIN class c ON s.class = c.class_name
                    LEFT JOIN attendance a ON s.student_id = a.student_id AND a.date = '$selected_date'
                    WHERE ('$class_filter' = 'all' OR c.class_name = '$class_filter')
                    ORDER BY c.class_name, s.last_name, s.first_name
                ";
                        $attendance_result = $conn->query($attendance_query);

                        while ($student = $attendance_result->fetch_assoc()):
                        ?>
                            <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 border"><?= $student['class_name'] ?></td>
                                <td class="px-4 py-2 border"><?= $student['student_id'] ?></td>
                                <td class="px-4 py-2 border"><?= $student['first_name'] ?></td>
                                <td class="px-4 py-2 border"><?= $student['last_name'] ?></td>
                                <td class="px-4 py-2 border text-center">
                                    <span class="<?= $student['status'] === 'present' ? 'text-green-600' : 'text-red-600' ?>">
                                        <?= ucfirst($student['status'] ?? 'Not Marked') ?>
                                    </span>
                                </td>
                                <td class="px-4 py-2 border text-center"><?= $student['days_present'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
</body>

<?php include('include/modals.php'); ?>
<?php include('include/head.php'); ?>