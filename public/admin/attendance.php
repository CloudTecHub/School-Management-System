<?php
include('include/side-bar.php');
?>

<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <section class="mb-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Generate Attendance Code for Staff</h2>

            <!-- Generate Code Form -->
            <form action="../session/checkin-code.php" method="post" class="mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <label for="num_numbers" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Number of Codes to Generate:</label>
                <input
                    type="number"
                    id="num_numbers"
                    name="num_numbers"
                    min="5"
                    max="100"
                    title="Minimum 5 and Maximum 100"
                    class="w-40 p-2 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-200" />
                <input
                    type="submit"
                    value="Generate"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition" />
            </form>

            <!-- Attendance Code Table -->
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-left border rounded shadow">
                    <thead class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="py-3 px-4 border-b">Check-in Code</th>
                            <th class="py-3 px-4 border-b">Used</th>
                            <th class="py-3 px-4 border-b">Date Created</th>
                            <th class="py-3 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../includes/database.php');
                        $sql = "SELECT * FROM checkin_code";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class='border-t'>";
                                echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>" . $row['number'] . "</td>";
                                echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>" . $row['is_used'] . "</td>";
                                echo "<td class='py-2 px-4 text-gray-800 dark:text-gray-100'>" . $row['created_at'] . "</td>";
                                echo "<td class='py-2 px-4'>
                                <a href='delete.php?table=checkin_code&id={$row['id']}'
                                   class='text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center justify-center'
                                   title='Delete'>
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4' />
                                    </svg>
                                </a>
                            </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='py-4 px-4 text-center text-gray-500 dark:text-gray-300'>No code created today</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php include('include/head.php'); ?>