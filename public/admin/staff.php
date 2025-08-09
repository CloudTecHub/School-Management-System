<?php
session_start();
error_reporting(0);
@ini_set('display_errors', 0);

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
  header("Location: ../../index.php");
  exit;
}

include('../../includes/database.php');

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle class filter
$classFilter = $_GET['class_filter'] ?? '';
$classWhere = $classFilter ? "WHERE class = '" . mysqli_real_escape_string($conn, $classFilter) . "'" : "";

// CSV Export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="staff.csv"');
  $output = fopen("php://output", "w");
  fputcsv($output, ['Staff ID', 'Full Name', 'Class', 'Email', 'Phone', 'Qualification', 'Position']);
  $exportSql = "SELECT * FROM staff $classWhere";
  $res = mysqli_query($conn, $exportSql);
  while ($row = mysqli_fetch_assoc($res)) {
    fputcsv($output, [
      $row['staff_id'],
      $row['first_name'] . ' ' . $row['mid_name'] . ' ' . $row['last_name'],
      $row['class'],
      $row['email'],
      $row['number'],
      $row['qualification'],
      $row['curr_position']
    ]);
  }
  fclose($output);
  exit;
}

// Handle AJAX fetch for edit
if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $result = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id='$id'");
  $row = mysqli_fetch_assoc($result);
  echo '
  <form id="editForm" method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" class="space-y-4">
    <input type="hidden" name="staff_id" value="' . $row['staff_id'] . '">
    <h3 class="text-lg font-semibold">Edit Staff</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label class="block">First Name</label><input type="text" name="first_name" value="' . $row['first_name'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Middle Name</label><input type="text" name="mid_name" value="' . $row['mid_name'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Last Name</label><input type="text" name="last_name" value="' . $row['last_name'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Phone Number</label><input type="text" name="number" value="' . $row['number'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Email</label><input type="email" name="email" value="' . $row['email'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Class</label><input type="text" name="class" value="' . $row['class'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Current Address</label><input type="text" name="curaddress" value="' . $row['curaddress'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">City Name</label><input type="text" name="cityname" value="' . $row['cityname'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Qualification</label><input type="text" name="qualification" value="' . $row['qualification'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Current Position</label><input type="text" name="curr_position" value="' . $row['curr_position'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Username</label><input type="text" name="username" value="' . $row['username'] . '" class="w-full border rounded p-2"></div>
      <div><label class="block">Password</label><input type="password" name="password" class="w-full border rounded p-2"></div>
      <div><label class="block">Confirm Password</label><input type="password" name="conpassword" class="w-full border rounded p-2"></div>
    </div>
    <div class="text-right">
      <button type="submit" name="update" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
    </div>
  </form>';
  exit;
}

// Handle update request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
  $id = mysqli_real_escape_string($conn, $_POST['staff_id']);
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $mid_name = mysqli_real_escape_string($conn, $_POST['mid_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $number = mysqli_real_escape_string($conn, $_POST['number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $class = mysqli_real_escape_string($conn, $_POST['class']);
  $curaddress = mysqli_real_escape_string($conn, $_POST['curaddress']);
  $cityname = mysqli_real_escape_string($conn, $_POST['cityname']);
  $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
  $curr_position = mysqli_real_escape_string($conn, $_POST['curr_position']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];
  $conpassword = $_POST['conpassword'];

  $sql = "UPDATE staff SET 
      first_name='$first_name',
      mid_name='$mid_name',
      last_name='$last_name',
      number='$number',
      email='$email',
      class='$class',
      curaddress='$curaddress',
      cityname='$cityname',
      qualification='$qualification',
      curr_position='$curr_position',
      username='$username'";

  if (!empty($password) && !empty($conpassword)) {
    if ($password === $conpassword) {
      $hashPassword = password_hash($password, PASSWORD_BCRYPT);
      $sql .= ", password='$hashPassword'";
    } else {
      echo "Passwords do not match.";
      exit;
    }
  }

  $sql .= " WHERE staff_id='$id'";
  if (mysqli_query($conn, $sql)) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } else {
    echo "Error updating: " . mysqli_error($conn);
  }
}

// Handle multiple deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_selected'])) {
  $ids = $_POST['selected_staff'] ?? [];
  if (!empty($ids)) {
    // Escape each ID and wrap in quotes for VARCHAR
    $escaped_ids = array_map(function ($id) use ($conn) {
      return "'" . mysqli_real_escape_string($conn, $id) . "'";
    }, $ids);

    $idList = implode(",", $escaped_ids);
    $deleteSql = "DELETE FROM staff WHERE staff_id IN ($idList)";

    if (mysqli_query($conn, $deleteSql)) {
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      echo "Error deleting records: " . mysqli_error($conn);
    }
  }
}

include('include/side-bar.php');
?>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
      <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">All Staff</h2>

      <form method="GET" class="flex items-center gap-4 mb-4">
        <select name="class_filter" onchange="this.form.submit()" class="w-60 p-2 border rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
          <option value="">All Classes</option>
          <?php
          include('../../includes/database.php');
          $res = $conn->query("SELECT DISTINCT class FROM staff");
          while ($row = $res->fetch_assoc()) {
            $selected = ($row['class'] === $classFilter) ? 'selected' : '';
            echo "<option value='{$row['class']}' $selected>{$row['class']}</option>";
          }
          ?>
        </select>
        <a href="?export=csv<?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"
          class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Export CSV</a>
      </form>

      <form method="POST">
        <section class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow w-full">
          <div class="min-w-full w-full px-2 sm:px-10">
            <table class="min-w-full w-full text-left table-auto">
              <thead class="bg-gray-100 dark:bg-gray-900">
                <tr>
                  <th class="py-3 px-4"><input type="checkbox" id="select_all" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"></th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">#</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">Staff ID</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">Full Name</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">Class</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">Position</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200">Status</th>
                  <th class="py-3 px-4 text-gray-700 dark:text-gray-200 text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM staff $classWhere LIMIT $limit OFFSET $offset";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                  $counter = ($page - 1) * $limit + 1;
                  while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr class='border-t'>";
                    echo "<td class='py-2 px-4'><input type='checkbox' name='selected_staff[]' value='{$row['staff_id']}' class='bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100'></td>";
                    echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>{$counter}</td>";
                    echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>{$row['staff_id']}</td>";
                    echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>{$row['first_name']} {$row['mid_name']} {$row['last_name']}</td>";
                    echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>{$row['class']}</td>";
                    echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>{$row['curr_position']}</td>";
                    echo "<td class='py-2 px-4 text-green-600 dark:text-green-400 font-medium'>Active</td>";
                    echo "<td class='py-2 px-4 flex justify-center gap-2'>
                          <a href=\"#\" title=\"Edit\" class=\"edit text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300\" data-id=\"{$row['staff_id']}\">
                            <i class=\"fas fa-edit\"></i>
                          </a>
                          <a href=\"delete.php?table=staff&id={$row['staff_id']}\" title=\"Delete\" class=\"text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300\">
                            <i class=\"fas fa-trash-alt\"></i>
                          </a>
                        </td>";
                    echo "</tr>";
                    $counter++;
                  }
                } else {
                  echo "<tr><td colspan='8' class='py-4 px-4 text-center text-gray-500 dark:text-gray-300'>No staff found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            <button type="submit" name="delete_selected" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Selected</button>
          </div>
        </section>
      </form>

      <?php
      $countRes = mysqli_query($conn, "SELECT COUNT(*) as total FROM staff $classWhere");
      $totalRows = mysqli_fetch_assoc($countRes)['total'];
      $totalPages = ceil($totalRows / $limit);
      ?>

      <div class="mt-4 flex justify-center gap-2">
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo $page - 1; ?><?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"
            class="px-3 py-1 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-400 dark:hover:bg-gray-600 rounded">Previous</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?page=<?php echo $page + 1; ?><?php echo $classFilter ? '&class_filter=' . $classFilter : ''; ?>"
            class="px-3 py-1 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-400 dark:hover:bg-gray-600 rounded">Next</a>
        <?php endif; ?>
      </div>
    </main>

    <!-- Modal -->
    <div id="modal_container" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-3xl p-6 relative">
        <button id="close" class="absolute top-3 right-3 text-gray-500 dark:text-gray-300 hover:text-black dark:hover:text-white text-xl">&times;</button>
        <div id="modalContent">
          <!-- Content will be loaded here via AJAX -->
        </div>
      </div>
    </div>

    <script>
      $(function() {
        // Select all checkbox functionality
        $("#select_all").change(function() {
          $("input[name='selected_staff[]']").prop('checked', $(this).prop("checked"));
        });

        $(".edit").click(function(e) {
          e.preventDefault();
          const staffId = $(this).data("id");
          $("#modal_container").removeClass("hidden");

          // Load the form via AJAX
          $.get("<?php echo $_SERVER['PHP_SELF']; ?>", {
            action: "fetch",
            id: staffId
          }, function(data) {
            $("#modalContent").html(data);

            // Apply dark mode classes to modal form elements
            $("#modalContent label").addClass("text-gray-700 dark:text-gray-200");
            $("#modalContent input, #modalContent select").addClass("bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700");
          });
        });

        $("#close").click(() => $("#modal_container").addClass("hidden"));
      });
    </script>
</body>
<?php include('include/modals.php'); ?>
<?php include('include/head.php'); ?>