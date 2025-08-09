<?php
// settings.php

// Include database connection
include('../../includes/database.php');

// --- Form Submission Handlers ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted using a hidden input
    $form_type = $_POST['form_type'] ?? '';

    // Handle School Details Update
    if ($form_type === 'school_details') {
        // Sanitize and validate input
        $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
        $type_of_institution = mysqli_real_escape_string($conn, $_POST['type_of_institution']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $enrollment_capacity = mysqli_real_escape_string($conn, $_POST['enrollment_capacity']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $facilities = mysqli_real_escape_string($conn, $_POST['facilities']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']);

        // Use a prepared statement for security
        $update_sql = "UPDATE school_details SET 
            school_name = ?, 
            type_of_institution = ?, 
            address = ?, 
            facilities = ?, 
            email = ?, 
            contact = ?, 
            enrollment_capacity = ?, 
            academic_year = ? 
        WHERE id = 1"; // Assuming a single row for school details with id = 1

        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssss",
            $school_name,
            $type_of_institution,
            $address,
            $facilities,
            $email,
            $contact,
            $enrollment_capacity,
            $academic_year
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "School details updated successfully!";
            $alert_type = "success";
        } else {
            $message = "Error updating school details: " . mysqli_error($conn);
            $alert_type = "error";
        }

        mysqli_stmt_close($stmt);

        // Handle Add New Administrator
    } elseif ($form_type === 'add_administrator') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Always hash passwords
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use a prepared statement for security
        $insert_sql = "INSERT INTO administrator (name, username, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Administrator added successfully!";
            $alert_type = "success";
        } else {
            $message = "Error adding administrator: " . mysqli_error($conn);
            $alert_type = "error";
        }

        mysqli_stmt_close($stmt);
    }
}

// --- Data Retrieval ---
// Retrieve school details
$sql_school = "SELECT * FROM school_details WHERE id = 1";
$result_school = mysqli_query($conn, $sql_school);
$school_details = mysqli_fetch_assoc($result_school);

// Retrieve administrator details
$sql_admins = "SELECT * FROM administrator";
$result_admins = mysqli_query($conn, $sql_admins);
$administrators = mysqli_fetch_all($result_admins, MYSQLI_ASSOC);

?>
<?php include('include/side-bar.php') ?>
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 sm:px-2 md:px-6 lg:px-8 xl:px-12 overflow-x-auto">
        <?php if (isset($message)): ?>
            <div class="p-4 mb-4 text-sm rounded-lg 
                <?php echo $alert_type === 'success' ? 'text-green-800 bg-green-50 dark:bg-green-900 dark:text-green-200' : 'text-red-800 bg-red-50 dark:bg-red-900 dark:text-red-200'; ?>" 
                role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- School Information Section -->
            <section class="col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                <h2 class="text-3xl font-bold mb-2 text-gray-800 dark:text-white">Settings</h2>
                <h3 class="text-lg font-semibold mb-8 text-gray-600 dark:text-gray-300">School Information</h3>
                <form method="POST" action="" enctype="multipart/form-data" class="space-y-8">
                    <input type="hidden" name="form_type" value="school_details">
                    <div class="flex items-center gap-6 mb-6">
                        <img src="../../assets/images/icons8-user-64.png" alt="User Icon" class="w-20 h-20 object-contain rounded-full border-2 border-gray-200 dark:border-gray-700 shadow" />
                        <input type="file" name="image" class="block text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">School Name</label>
                            <input type="text" name="school_name" value="<?php echo htmlspecialchars($school_details['school_name']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Type of Institution</label>
                            <input type="text" name="type_of_institution" value="<?php echo htmlspecialchars($school_details['type_of_institution']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($school_details['address']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Enrollment Capacity</label>
                            <input type="text" name="enrollment_capacity" value="<?php echo htmlspecialchars($school_details['enrollment_capacity']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Facilities</label>
                            <input type="text" name="facilities" value="<?php echo htmlspecialchars($school_details['facilities']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($school_details['email']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Contact</label>
                            <input type="text" name="contact" value="<?php echo htmlspecialchars($school_details['contact']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Academic Year</label>
                            <input type="text" name="academic_year" value="<?php echo htmlspecialchars($school_details['academic_year']); ?>" class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow transition">Save School Details</button>
                    </div>
                </form>
            </section>

            <!-- Administrators Table Section -->
            <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 h-fit">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">Administrators</span>
                    <a href="#" onclick="document.getElementById('adminFormModal').classList.remove('hidden')" class="text-blue-600 font-medium hover:underline">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full text-left border rounded">
                        <thead class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="py-3 px-4 border-b">Name</th>
                                <th class="py-3 px-4 border-b">Username</th>
                                <th class="py-3 px-4 border-b text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($administrators): ?>
                                <?php foreach ($administrators as $admin): ?>
                                    <tr class='border-t'>
                                        <td class='py-2 px-4 text-gray-800 dark:text-gray-100'><?php echo htmlspecialchars($admin['name']); ?></td>
                                        <td class='py-2 px-4 text-gray-800 dark:text-gray-100'><?php echo htmlspecialchars($admin['username']); ?></td>
                                        <td class='py-2 px-4 text-center'>
                                            <a href="#" onclick="document.getElementById('editAdminModal_<?php echo $admin['id']; ?>').classList.remove('hidden')" class="inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete.php?table=administrator&id=<?php echo $admin['id']; ?>" class="inline-block text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan='3' class='py-4 px-4 text-center text-gray-500 dark:text-gray-300'>No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Add Admin (already styled, but you can add dark mode if needed) -->
    <div id="adminFormModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Add New Administrator</h3>
                <div class="mt-2 px-7 py-3">
                    <form method="POST" action="">
                        <input type="hidden" name="form_type" value="add_administrator">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-left text-gray-700 dark:text-gray-200">Name</label>
                            <input type="text" name="name" required class="w-full border border-gray-300 dark:border-gray-700 rounded px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-left text-gray-700 dark:text-gray-200">Username</label>
                            <input type="text" name="username" required class="w-full border border-gray-300 dark:border-gray-700 rounded px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-left text-gray-700 dark:text-gray-200">Password</label>
                            <input type="password" name="password" required class="w-full border border-gray-300 dark:border-gray-700 rounded px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                        </div>
                        <div class="items-center px-4 py-3">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700">Add Admin</button>
                            <button type="button" onclick="document.getElementById('adminFormModal').classList.add('hidden')" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/head.php') ?>

    <style>
        @media (max-width: 640px) {
            main {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
    </style>
</div>