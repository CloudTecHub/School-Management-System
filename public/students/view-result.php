<?php include('include/side-bar.php'); ?>

<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
    <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-3 sm:p-5 overflow-x-auto">
      <h2 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-white mb-4 sm:mb-6">Results</h2>

      <div class="w-full overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
          <thead class="bg-cyan-500 text-white">
            <tr>
              <th class="px-2 sm:px-3 py-2 sm:py-3 text-left font-medium uppercase tracking-wide">Number</th>
              <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium uppercase tracking-wide">Report</th>
              <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium uppercase tracking-wide">Date / Time</th>
              <th class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium uppercase tracking-wide">Download</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">
            <?php
            include('../../includes/database.php');
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM results WHERE student_id=(SELECT student_id FROM students WHERE username='$username')";
            $result = mysqli_query($conn, $sql);
            $counter = 1;
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $file_path = "../../resultroom/" . $row["filename"];
            ?>
                <tr>
                  <td class="px-2 sm:px-3 py-2 sm:py-3"><?php echo $counter++; ?></td>
                  <td class="px-2 sm:px-4 py-2 sm:py-3 break-words max-w-xs"><?php echo $row["filename"]; ?></td>
                  <td class="px-2 sm:px-4 py-2 sm:py-3"><?php echo $row["upload_date"]; ?></td>
                  <td class="px-2 sm:px-4 py-2 sm:py-3">
                    <a href="<?php echo $file_path; ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm px-3 py-1.5 rounded" download>
                      Download
                    </a>
                  </td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="4" class="px-2 py-3 text-center text-gray-500 dark:text-gray-400">No results found</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <?php include('include/head.php'); ?>