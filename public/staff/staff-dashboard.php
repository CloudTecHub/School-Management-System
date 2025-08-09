<?php
include('include/side-bar.php')
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
// Include database connection
include('../../includes/database.php');
function getUserCountSummary($conn)
{
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
function getTotalStaffs($conn)
{
    $sql = "SELECT COUNT(*) AS total_staffs FROM staff";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_staffs'];
}

function getTotalStudents($conn)
{
    $sql = "SELECT COUNT(*) AS total_students FROM students";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_students'];
}

$totalStaffs = getTotalStaffs($conn);
$totalStudents = getTotalStudents($conn);
$userSummary = getUserCountSummary($conn);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Main container -->
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="flex items-center gap-4">
                <?php
                $result = $conn->query("SELECT * FROM school_details LIMIT 1");
                $school_details = $result->fetch_assoc();
                if ($school_details) {
                    echo "<h1 class='text-3xl font-bold text-gray-800 dark:text-white'>" . $school_details['school_name'] . "</h1>";
                }
                ?>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-2 rounded-lg">
                <p class="text-blue-800 dark:text-blue-200 font-medium">Academic Year: <?php echo $school_details['academic_year'] ?? '2024/2025'; ?></p>
            </div>
        </div>

        <!-- Stats Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <!-- Students Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-md hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 mb-1">Students</h2>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?php echo $totalStudents; ?></p>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total enrolled students</p>
                </div>
            </div>

            <!-- Staff Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-md hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 mb-1">Staff</h2>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo $totalStaffs; ?></p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Teaching and administrative staff</p>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-md hover:-translate-y-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 mb-1">Total Users</h2>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?php echo $userSummary['TOTAL']; ?></p>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">All system users combined</p>
                </div>
            </div>
        </section>

        <!-- Chart Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">User Distribution</h2>
                <canvas id="userChart" class="w-full"></canvas>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Quick Stats</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Student to Staff Ratio</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                            <?php echo round($totalStudents / max($totalStaffs, 1), 1); ?>:1
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Enrollment Capacity</p>
                        <div class="flex items-center gap-4">
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                <?php echo $school_details['enrollment_capacity'] ?? 'N/A'; ?>
                            </p>
                            <?php if (isset($school_details['enrollment_capacity'])): ?>
                                <?php
                                $capacity = $school_details['enrollment_capacity'];
                                $percentage = min(round(($totalStudents / $capacity) * 100), 100);
                                $color = $percentage > 90 ? 'bg-red-500' : ($percentage > 75 ? 'bg-yellow-500' : 'bg-green-500');
                                ?>
                                <div class="flex-1">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full <?php echo $color; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo $percentage; ?>% filled</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- School Details Section -->
        <section class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">SCHOOL DETAILS</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php
                    include('../../includes/database.php');
                    $sql = "SELECT * FROM school_details LIMIT 1";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $fields = [
                            'school_name' => ['label' => 'School Name', 'icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2a1 1 0 011 1v8a1 1 0 01-1 1h-1m-6 1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'],
                            'type_of_institution' => ['label' => 'Institution Type', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            'address' => ['label' => 'Address', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                            'email' => ['label' => 'Email', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            'contact' => ['label' => 'Contact', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                            'academic_year' => ['label' => 'Academic Year', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z']
                        ];

                        foreach ($fields as $key => $data) {
                            echo '<div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">';
                            echo '<div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg flex-shrink-0">';
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $data['icon'] . '" />';
                            echo '</svg>';
                            echo '</div>';
                            echo '<div>';
                            echo '<h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">' . $data['label'] . '</h3>';
                            echo '<p class="text-lg font-medium text-gray-800 dark:text-white mt-1">' . ($row[$key] ?? 'N/A') . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Students', 'Staff'],
            datasets: [{
                label: 'User Distribution',
                data: [<?php echo $totalStudents; ?>, <?php echo $totalStaffs; ?>],
                backgroundColor: ['#3b82f6', '#10b981'],
                borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1f2937' : '#f3f4f6',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1f2937' : '#ffffff',
                    titleColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                    bodyColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#d1d5db' : '#374151',
                    borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#d1d5db',
                    borderWidth: 1
                }
            },
            cutout: '70%'
        }
    });
</script>

<?php include('include/head.php'); ?>