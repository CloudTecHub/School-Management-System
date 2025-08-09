<?php
include('include/side-bar.php');
?>
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <div>
            <div>
                <div class="tab">
                    <table class="table table-striped table-hover">
                        <form action='sort-attendance.php' method='post' style='margin: 100px;'>
                            <select class="std-input-box" id="staff_id" name="staff_id" required>
                                <option name="staff_id">Sort ID<?php
                                                                include('../../includes/database.php');
                                                                $sql = "SELECT * FROM staff";
                                                                $result = $conn->query($sql);
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo '<option value="' . $row["staff_id"] . '">' . $row["staff_id"] . '</option>';
                                                                }
                                                                $conn->close();
                                                                ?></option>
                            </select>
                            <input type="submit" class="sort-btn" value="Search" style="background-color: black; width:70px; color:white; border:none; border-radius:5px;">
                        </form>
                        <tr>
                            <div>
                                <th class="tab-head">Staff ID</th>
                                <!-- <th class="tab-head">Name</th> -->
                                <th class="tab-head">Check In Time</th>
                            </div>
                        </tr>
                        <?php
                        error_reporting(0);
                        @ini_set('display_error', 0);
                        include('../../includes/database.php');
                        // Display data
                        $sql = "SELECT * FROM staff_attendance";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='tab-data'>" . $row['staff_id'] . "</td>";
                                //echo "<td class='tab-data'>" . $row['first_name'] . " " . $row['mid_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td class='tab-data' id='check'>" . $row['check_in_time'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No code created today</td></tr>";
                        }
                        ?>
                    </table>

                </div>
            </div>
        </div>
        <?php include('include/head.php'); ?>