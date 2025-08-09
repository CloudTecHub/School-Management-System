<?php
include('include/side-bar.php');
include '../../includes/database.php';
// Check if user is admin
if (!isset($_SESSION['username']) && ($_SESSION['role'] !== 'administrator')) {
  header("Location:../../index.php");
  exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $staff_id = $conn->real_escape_string($_POST['staff_id']);
  $class_name = $conn->real_escape_string($_POST['class_name']); // Instead of class_id

  $sql = "INSERT INTO staff_classes (staff_id, class_name) 
        VALUES ('$staff_id', 
               (SELECT class_name FROM class WHERE class_name = '$class_name'))";

  if ($conn->query($sql)) {
    $success = "Staff member successfully assigned to class!";
  } else {
    $error = "Error assigning staff to class: " . $conn->error;
  }
}

// Fetch staff and classes for dropdowns
$staff_result = $conn->query("SELECT staff_id, CONCAT(first_name, ' ', last_name) AS name FROM staff");
$classes_result = $conn->query("SELECT class_id, class_name FROM class");

?>

<body class="bg-gray-100 text-gray-900">
  <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
      <div class="min-h-screen p-6 bg-gray-100 flex flex-col items-center">
        <h1 class="text-3xl font-bold text-gray-900">Assign Staff to Class</h1>

        <?php if (isset($success)): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= $success ?>
          </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= $error ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-4">
            <label for="staff_id" class="block text-gray-700 font-medium mb-2">Staff Member</label>
            <select id="staff_id" name="staff_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
              <option value="">Select Staff</option>
              <?php while ($s = $staff_result->fetch_assoc()): ?>
                <option value="<?= $s['staff_id'] ?>"><?= $s['name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="class_name" class="block text-gray-700 font-medium mb-2">Class</label>
            <select id="class_name" name="class_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
              <option value="">Select Class</option>
              <?php while ($c = $classes_result->fetch_assoc()): ?>
                <option value="<?= $c['class_name'] ?>"><?= $c['class_name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Assign to Class
          </button>
        </form>
      </div>
  </div>
  </main>
</body>

</html>
<?php include('include/modals.php'); ?>
<?php include('include/head.php'); ?>