
<?php include('include/side-bar.php'); ?>

<body class="bg-gray-100 text-gray-900">
    <main class="p-4 lg:ml-64">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- CLASSES CARD -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-pink-600 p-4">
                    <h4 class="text-white font-bold">CLASSES</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Class ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Class Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            include('../../includes/database.php');
                            $sql = "SELECT * FROM class";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['class_id'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['class_name'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' class='px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SUBJECTS CARD -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-600 p-4">
                    <h4 class="text-white font-bold">SUBJECTS</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Subject ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Subject Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            include('../../includes/database.php');
                            $sql = "SELECT * FROM subjects";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['subject_id'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['subject_name'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' class='px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TESTS CARD -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-2 lg:col-span-1">
                <div class="bg-pink-600 p-4">
                    <h4 class="text-white font-bold">TESTS</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Term</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Class Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-pink-600 uppercase tracking-wider">End Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            include('../../includes/database.php');
                            $sql = "SELECT * FROM test";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['term'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['type'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['class_nm'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['start_date'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>" . $row['end_date'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
<?php include('include/head.php'); ?>