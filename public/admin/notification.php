<?php
// notifications.php
include 'include/side-bar.php';
// Display errors for debugging (remove in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../includes/database.php');

// Dummy database connection for demonstration


// --- Handle Notification Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'send_notification') {
    $message = trim($_POST['message']);
    $targetRole = $_POST['target_role'];
    $senderName = 'Administrator'; // You can fetch this from a session if an admin is logged in

    if (!empty($message) && in_array($targetRole, ['all', 'student', 'staff'])) {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO notifications (message, target_role, sender_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $message, $targetRole, $senderName);

        if ($stmt->execute()) {
            $status_message = "Notification sent successfully!";
            $status_type = "success";
        } else {
            $status_message = "Error sending notification: " . $stmt->error;
            $status_type = "error";
        }
    } else {
        $status_message = "Please provide a message and select a valid target audience.";
        $status_type = "error";
    }
}

// --- Handle Notification Deletion ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_notification_id'])) {
    $delete_id = intval($_POST['delete_notification_id']);
    $delete_query = "DELETE FROM notifications WHERE notification_id = $delete_id";
    if ($conn->query($delete_query)) {
        $status_message = "Notification deleted successfully!";
        $status_type = "success";
    } else {
        $status_message = "Error deleting notification: " . $conn->error;
        $status_type = "error";
    }
}

// --- Fetch Notifications for Display ---
// For simplicity, this page will display all notifications.
// In a real system, students/staff would see notifications relevant to them on their dashboards.
$all_notifications_query = "SELECT * FROM notifications ORDER BY created_at DESC";
$all_notifications_result = $conn->query($all_notifications_query);
$all_notifications = $all_notifications_result ? $all_notifications_result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
    }

    /* .container-shadow {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    } */
</style>
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900 flex flex-col items-center">
                <header class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-xl container-shadow p-6 mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Notification Management</h1>
                    <p class="text-gray-500 dark:text-gray-300 mt-2">Send and view announcements for students and staff.</p>
                </header>

                <div class="w-full max-w-4xl grid grid-cols-1 gap-6">

                    <!-- Status Message Display -->
                    <?php if (isset($status_message)): ?>
                        <div class="p-4 rounded-lg <?php echo $status_type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'; ?> container-shadow">
                            <?php echo htmlspecialchars($status_message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Button to open modal -->
                    <div class="flex justify-end">
                        <button onclick="document.getElementById('modal-form').classList.remove('hidden')"
                            class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Send New Notification
                        </button>
                    </div>

                    <!-- Modal Popup Form -->
                    <div id="modal-form" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-xl container-shadow p-6 w-full max-w-lg relative">
                            <button onclick="document.getElementById('modal-form').classList.add('hidden')"
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white text-2xl">&times;</button>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Send New Notification</h2>
                            <form action="" method="POST" class="space-y-4">
                                <input type="hidden" name="form_type" value="send_notification">
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Message</label>
                                    <textarea id="message" name="message" rows="4" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                        placeholder="Type your announcement here..."></textarea>
                                </div>
                                <div>
                                    <label for="target_role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Send To</label>
                                    <select id="target_role" name="target_role" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                        <option value="all">All (Students & Staff)</option>
                                        <option value="student">Students Only</option>
                                        <option value="staff">Staff Only</option>
                                    </select>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-6 rounded-lg 
                                                        hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200 ease-in-out">
                                        <i class="fas fa-paper-plane mr-2"></i>Send Notification
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <!-- Sent Notifications List -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl container-shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Sent Notifications</h2>
                        <div class="space-y-4">
                            <?php if (!empty($all_notifications)): ?>
                                <?php foreach ($all_notifications as $notification): ?>
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                    To: <span class="capitalize font-semibold"><?php echo htmlspecialchars($notification['target_role']); ?></span>
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    Sent by: <?php echo htmlspecialchars($notification['sender_name']); ?> on <?php echo date('M d, Y H:i', strtotime($notification['created_at'])); ?>
                                                </span>
                                            </div>
                                            <p class="text-gray-800 dark:text-gray-200 text-base"><?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                                        </div>
                                        <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                            <input type="hidden" name="delete_notification_id" value="<?php echo $notification['notification_id']; ?>">
                                            <button type="submit" class="mt-2 md:mt-0 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 dark:hover:bg-red-800 transition">
                                                <i class="fas fa-trash-alt mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-gray-500 dark:text-gray-400">No notifications sent yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                // Optional: Close modal on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === "Escape") {
                        document.getElementById('modal-form').classList.add('hidden');
                    }
                });
            </script>
</body>

</html>
<?php include 'include/modals.php'; ?>