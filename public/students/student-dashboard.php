<?php include('include/side-bar.php'); ?>
<?php
include('../../includes/database.php');

$username = $_SESSION['username'];
$sql = "SELECT * FROM students WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);
?>

<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Profile Card -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-md p-3 text-sm">
                <h2 class="text-base font-semibold text-gray-700 dark:text-white mb-2">Profile</h2>
                <ul class="text-gray-600 dark:text-gray-300 space-y-1">
                    <li><strong>ID:</strong> <?php echo $student['student_id']; ?></li>
                    <li><strong>Name:</strong> <?php echo $student['first_name'] . ' ' . $student['last_name']; ?></li>
                    <li><strong>Email:</strong> <?php echo $student['email']; ?></li>
                    <li><strong>Phone:</strong> <?php echo $student['parent_number']; ?></li>
                </ul>
            </div>

            <!-- Results Overview -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-md p-3 text-sm">
                <h2 class="text-base font-semibold text-gray-700 dark:text-white mb-2">Recent Result</h2>
                <?php
                $sql_result = "SELECT * FROM results WHERE student_id='{$student['student_id']}' ORDER BY upload_date DESC LIMIT 1";
                $res_result = mysqli_query($conn, $sql_result);
                if (mysqli_num_rows($res_result) > 0) {
                    $latest = mysqli_fetch_assoc($res_result);
                ?>
                    <p class="text-gray-600 dark:text-gray-300"><strong><?php echo $latest['filename']; ?></strong></p>
                    <p class="text-xs text-gray-500"><?php echo $latest['upload_date']; ?></p>
                <?php } else { ?>
                    <p class="text-gray-500 text-sm">No results available.</p>
                <?php } ?>
            </div>

            <!-- Notifications -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-md p-3 text-sm">
                <h2 class="text-base font-semibold text-gray-700 dark:text-white mb-2">Notifications</h2>
                <?php
                $sql_notify = "SELECT * FROM notifications  ORDER BY created_at DESC LIMIT 1";
                $not_result = mysqli_query($conn, $sql_notify);
                if (mysqli_num_rows($not_result) > 0) {
                    $latest_notification = mysqli_fetch_assoc($not_result);
                ?>
                    <br>
                    <p class="text-gray-600 dark:text-gray-300"><strong><?php echo "<span style='color:blueviolet;'>" . 'New notification ' . "</span>" . "<span style='color:blue;'>" . 'created at ' . "</span>" . $latest_notification['created_at'],  ' by ' . "<span style='color:limegreen;'>" . $latest_notification['sender_name'] . "</span>" ?></strong></p>
                <?php } else { ?>
                    <p class="text-gray-600 dark:text-gray-300">You have no new notifications.</p>
                <?php } ?>
            </div>
        </section>
</div>
</main>

<?php include('include/head.php'); ?>