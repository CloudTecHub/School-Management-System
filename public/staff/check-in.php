<?php
include('include/side-bar.php');
include('../../includes/database.php');
$sqlS = "SELECT staff_id FROM staff";
$resultS = mysqli_query($conn, $sqlS);
$rowS = mysqli_fetch_assoc($resultS);
?>


<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">CHECK IN HERE</h2>
            <div class="checkin-container mb-8">
                <form id="checkInForm" class="space-y-6">
                    <div>
                        <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-1">Staff ID:</label>
                        <input type="text" class="chk-input-box w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $rowS['staff_id']; ?>" id="staff_id" name="staff_id" required>
                    </div>
                    <div>
                        <label for="checkin_code" class="block text-sm font-medium text-gray-700 mb-1">Check-in Code:</label>
                        <input type="text" class="chk-input-box w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" id="checkin_code" name="checkin_code" required>
                    </div>
                    <div>
                        <input type="submit" class="input-btn w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition" value="Check In">
                    </div>
                </form>
                <div id="message" class="message mt-4 text-center text-green-600"></div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200 rounded-lg shadow">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Your ID</th>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Check In Time</th>
                            <th class="tab-head px-4 py-2 text-left font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // error_reporting(0);
                        // @ini_set('display_error', 0);
                        // Display data
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM staff_attendance WHERE staff_id=(SELECT staff_id FROM staff WHERE username='$username')";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='tab-data px-4 py-2 border-t'>" . $row['staff_id'] . "</td>";
                                echo "<td class='tab-data px-4 py-2 border-t'>" . $row['check_in_time'] . "</td>";
                                echo "<td class='tab-data px-4 py-2 border-t'><a class='delete text-red-600 hover:underline' id='autoDelete' href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-4 text-center text-gray-500'>You haven't entered any code today.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('checkInForm').addEventListener('submit', function(event) {
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../session/checkin-process.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('message').innerText = this.responseText;
                } else {
                    document.getElementById('message').innerText = 'Error: ' + this.responseText;
                }
            };
            xhr.send(formData);
        });
    </script>
    <?php
    include('include/head.php')
    ?>