<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <?php include('include/side-bar.php'); ?>
    <?php
    // Include database connection
    include('../../includes/database.php');



    // Fetch notifications relevant to the student
    $notifications_query = "
        SELECT message, sender_name, created_at
        FROM notifications
        WHERE target_role = 'all' OR target_role = 'staff'
        ORDER BY created_at DESC
        LIMIT 10;
    ";
    $notifications_result = $conn->query($notifications_query);
    $student_notifications = $notifications_result ? $notifications_result->fetch_all(MYSQLI_ASSOC) : [];

    $conn->close();
    ?>

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="mt-16"> <!-- Added margin-top for header spacing -->
                <div class="w-full max-w-3xl">
                    <div class="bg-white rounded-xl container-shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Notifications</h2>
                        <div class="space-y-3">
                            <?php if (!empty($student_notifications)): ?>
                                <?php foreach ($student_notifications as $notification): ?>
                                    <div class="border border-gray-200 rounded-lg p-3 bg-blue-50">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs text-gray-600">From: <?php echo htmlspecialchars($notification['sender_name']); ?></span>
                                            <span class="text-xs text-gray-500"><?php echo date('M d, Y H:i', strtotime($notification['created_at'])); ?></span>
                                        </div>
                                        <p class="text-gray-800 text-sm"><?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-gray-500 text-sm">No new notifications for you.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>
<?php include('include/head.php'); ?>