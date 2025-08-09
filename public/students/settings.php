<?php
include('include/side-bar.php');
include('../../includes/database.php'); // Should set $conn = mysqli_connect(...);

$current_username = $_SESSION['username'];
$error = '';
$success = '';

// Fetch current student data
$query = "SELECT * FROM students WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $current_username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    $error = "Student not found!";
} else {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = trim($_POST['first_name']);
        $mid_name = trim($_POST['mid_name']);
        $last_name = trim($_POST['last_name']);
        $number = trim($_POST['number']);
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        // Validate current password if changing password
        if (!empty($new_password)) {
            if (!password_verify($current_password, $student['password'])) {
                $error = "Current password is incorrect";
            } elseif ($new_password !== $confirm_password) {
                $error = "New passwords do not match";
            } elseif (strlen($new_password) < 8) {
                $error = "Password must be at least 8 characters long";
            }
        }

        // Check if new username or email already exists (excluding current user)
        if (empty($error) && $username !== $current_username) {
            $query = "SELECT student_id FROM students WHERE username = ? AND student_id != ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $username, $student['student_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_fetch_assoc($result)) {
                $error = "Username already taken";
            }
        }

        if (empty($error) && $email !== $student['email']) {
            $query = "SELECT student_id FROM students WHERE email = ? AND student_id != ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $email, $student['student_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_fetch_assoc($result)) {
                $error = "Email already in use";
            }
        }

        // If no errors, update the record
        if (empty($error)) {
            $fields = "first_name=?, mid_name=?, last_name=?, number=?, email=?, username=?";
            $params = [$first_name, $mid_name, $last_name, $number, $email, $username];
            $types = "ssssss";

            if (!empty($new_password)) {
                $fields .= ", password=?";
                $params[] = password_hash($new_password, PASSWORD_BCRYPT);
                $types .= "s";
            }

            $params[] = $student['student_id'];
            $types .= "i";

            $query = "UPDATE students SET $fields WHERE student_id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, $types, ...$params);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Profile updated successfully!";
                if ($username !== $current_username) {
                    $_SESSION['username'] = $username;
                }
                // Refresh student data
                $query = "SELECT * FROM students WHERE username = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $student = mysqli_fetch_assoc($result);
            } else {
                $error = "Error updating profile";
            }
        }
    }
}
?>

<body class="bg-gray-100">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-600 py-4 px-6">
                    <h1 class="text-2xl font-bold text-white">Student Settings</h1>
                </div>

                <div class="p-6">
                    <?php if (!empty($error)): ?>
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-6">
                        <section class="col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name'] ?? ''); ?>"
                                         class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label for="mid_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                                    <input type="text" id="mid_name" name="mid_name" value="<?php echo htmlspecialchars($student['mid_name'] ?? ''); ?>"
                                         class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name'] ?? ''); ?>"
                                         class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                            </div>

                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($student['number'] ?? ''); ?>"
                                     class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>"
                                     class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($student['username'] ?? ''); ?>"
                                     class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Change Password</h2>

                                <div class="space-y-4">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                             class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>

                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" id="new_password" name="new_password"
                                             class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                                    </div>

                                    <div>
                                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                             class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Save Changes
                                </button>
                            </div>
                    </form>
                </div>
            </div>
    </div>
</body>

</html>
<?php
include('include/head.php'); // Should include necessary head elements
?>