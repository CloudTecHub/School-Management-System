<?php

// Database connection
include '../../includes/database.php';

// Fetch classes with error handling
$classes_query = "SELECT class_name FROM class";
$classes_result = $conn->query($classes_query);
$classes = [];
if ($classes_result->num_rows > 0) {
    $classes = $classes_result->fetch_all(MYSQLI_ASSOC);
}

// Fetch fees structure with error handling
$fs_query = "SELECT * FROM fee_structures";
$fs_result = $conn->query($fs_query);
$feeStructures = [];
if ($fs_result->num_rows > 0) {
    $feeStructures = $fs_result->fetch_all(MYSQLI_ASSOC);
}

// Fetch students with error handling
$student_query = "SELECT * FROM students";
$student_result = $conn->query($student_query);
$students = [];
if ($student_result->num_rows > 0) {
    $students = $student_result->fetch_all(MYSQLI_ASSOC);
}

// Calculate outstanding fees
$outstandingFees_query = "SELECT s.student_id, s.first_name, s.last_name, s.class_name, 
                                fs.fee_id, fs.fee_type, fs.amount, fs.due_date
                         FROM students s
                         JOIN fee_structures fs ON s.class_name = fs.class_name
                         LEFT JOIN payments p ON s.student_id = p.student_id AND fs.fee_id = p.fee_id
                         WHERE p.payment_id IS NULL";
$outstandingFees_result = $conn->query($outstandingFees_query);
$outstandingFees = [];
if ($outstandingFees_result && $outstandingFees_result->num_rows > 0) {
    $outstandingFees = $outstandingFees_result->fetch_all(MYSQLI_ASSOC);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_class':
                $className = $conn->real_escape_string($_POST['class_name']);
                $conn->query("INSERT INTO class (class_name) VALUES ('$className')");
                $_SESSION['message'] = "Class added successfully!";
                break;

            case 'add_fee_structure':
                $className = $conn->real_escape_string($_POST['class_name']);
                $feeType = $conn->real_escape_string($_POST['fee_type']);
                $amount = (float)$_POST['amount'];
                $dueDate = $conn->real_escape_string($_POST['due_date']);
                $conn->query("INSERT INTO fee_structures (class_name, fee_type, amount, due_date) 
                             VALUES ('$className', '$feeType', $amount, '$dueDate')");
                $_SESSION['message'] = "Fee structure added successfully!";
                break;

            case 'add_student':
                $firstName = $conn->real_escape_string($_POST['first_name']);
                $lastName = $conn->real_escape_string($_POST['last_name']);
                $className = $conn->real_escape_string($_POST['class_name']);
                $conn->query("INSERT INTO students (first_name, last_name, class_name) 
                             VALUES ('$firstName', '$lastName', '$className')");
                $_SESSION['message'] = "Student added successfully!";
                break;

            case 'collect_fee':
            case 'collect_fee':
                // Validate required fields
                if (
                    isset($_POST['student_id'], $_POST['fee_id'], $_POST['amount_paid'], $_POST['payment_method']) &&
                    $_POST['student_id'] !== '' &&
                    $_POST['fee_id'] !== '' &&
                    $_POST['amount_paid'] !== '' &&
                    $_POST['payment_method'] !== ''
                ) {
                    $studentId = $conn->real_escape_string($_POST['student_id']);
                    $feeId = (int)$_POST['fee_id'];
                    $amountPaid = (float)$_POST['amount_paid'];
                    $paymentMethod = $conn->real_escape_string($_POST['payment_method']);
                    $receiptNumber = 'RCPT-' . time() . rand(100, 999);

                    $insert = $conn->query("INSERT INTO payments (student_id, fee_id, amount_paid, payment_method, receipt_number, payment_date) 
                        VALUES ('$studentId', $feeId, $amountPaid, '$paymentMethod', '$receiptNumber', NOW())");

                    if ($insert) {
                        $_SESSION['message'] = "Payment recorded successfully! Receipt #: $receiptNumber";
                    } else {
                        $_SESSION['message'] = "Error recording payment: " . $conn->error;
                    }
                } else {
                    $_SESSION['message'] = "Please fill in all required fields.";
                }
                break;

            case 'send_reminder':
                $studentId = (int)$_POST['student_id'];
                $feeId = (int)$_POST['fee_id'];
                $_SESSION['message'] = "Reminder sent successfully!";
                break;
        }
    }
    // Redirect to the same tab after form submission
    $redirectTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
    header("Location: " . $_SERVER['PHP_SELF'] . "?tab=" . urlencode($redirectTab));
    exit();
}

// Handle deletions
if (isset($_GET['delete'])) {
    $type = $_GET['delete'];
    $id = (int)$_GET['id'];
    switch ($type) {
        case 'fee_structure':
            $conn->query("DELETE FROM fee_structures WHERE fee_id = $id");
            $_SESSION['message'] = "Fee structure deleted successfully!";
            break;
        case 'student':
            $conn->query("DELETE FROM students WHERE student_id = $id");
            $_SESSION['message'] = "Student deleted successfully!";
            break;
        case 'payment':
            $conn->query("DELETE FROM payments WHERE payment_id = $id");
            $_SESSION['message'] = "Payment record deleted successfully!";
            break;
    }
    $redirectTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
    header("Location: " . $_SERVER['PHP_SELF'] . "?tab=" . urlencode($redirectTab));
    exit();
}

$conn->close();

// Tab logic
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'fee-structure';
$tabs = [
    'fee-structure' => ['icon' => 'fa-calculator', 'label' => 'Fee Structure'],
    'fee-collection' => ['icon' => 'fa-money-bill-wave', 'label' => 'Fee Collection'],
    'reminders' => ['icon' => 'fa-bell', 'label' => 'Due Fee Reminders'],
    'transactions' => ['icon' => 'fa-history', 'label' => 'Transaction History'],

];

?>

<?php include 'include/side-bar.php'; ?>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
            <div class="container mx-auto px-2 sm:px-4">
                <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6 text-blue-800 dark:text-blue-300">Fees Management System</h1>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                        <?php echo $_SESSION['message'];
                        unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <!-- Responsive Tabs -->
                    <div class="flex flex-col sm:flex-row border-b overflow-x-auto bg-gray-50 dark:bg-gray-900">
                        <?php foreach ($tabs as $tabId => $tabInfo): ?>
                            <a href="?tab=<?php echo $tabId; ?>"
                                class="tab-button py-3 px-4 sm:py-4 sm:px-6 font-medium text-sm sm:text-base whitespace-nowrap
                                 <?php echo ($activeTab === $tabId) ? ' bg-blue-600 text-white dark:bg-blue-500 dark:text-gray-100' : ' text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                                <i class="fas <?php echo $tabInfo['icon']; ?> mr-2"></i><?php echo $tabInfo['label']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Tab Contents -->
                    <div class="p-4 sm:p-6 bg-gray-50 dark:bg-gray-900">
                        <?php if ($activeTab === 'fee-structure'): ?>
                            <div id="fee-structure" class="tab-content active">
                                <?php include 'fees/fee-structure.php'; ?>
                            </div>

                        <?php elseif ($activeTab === 'fee-collection'): ?>
                            <div id="fee-collection" class="tab-content active">
                                <?php include 'fees/fee-collection.php'; ?>
                            </div>

                        <?php elseif ($activeTab === 'reminders'): ?>
                            <div id="reminders" class="tab-content active">
                                <?php include 'fees/fee-reminder.php'; ?>
                            </div>

                        <?php elseif ($activeTab === 'transactions'): ?>
                            <div id="transactions" class="tab-content active">
                                <?php include 'fees/transaction-history.php'; ?>
                            </div>

                        <?php else: ?>
                            <div class="tab-content active">
                                <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">Welcome to the Fees Management System</h2>
                                <p class="text-gray-600 dark:text-gray-300">Please select a tab to manage fees, view transactions, or manage data.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>

        <script>
            // Make openTab globally available
            window.openTab = function(tabId, event) {
                if (event) event.preventDefault();

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Deactivate all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active');
                });

                // Show the selected tab content
                document.getElementById(tabId).classList.add('active');

                // Activate the clicked button
                if (event) {
                    event.currentTarget.classList.add('active');
                }
            };

            // Initialize active tab as per PHP variable on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Get active tab from PHP
                const activeTab = "<?php echo $activeTab; ?>";

                // Activate the correct tab button
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active');
                    if (button.getAttribute('href').includes(activeTab)) {
                        button.classList.add('active');
                    }
                });

                // Show the correct tab content
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                    if (tab.id === activeTab) {
                        tab.classList.add('active');
                    }
                });
            });

            // Modal functionality
            function showModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function hideModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Update fee options based on selected student
            function updateFeeOptions(studentId) {
                if (!studentId) {
                    document.getElementById('fee-options').innerHTML = '<option value="">Select Fee</option>';
                    return;
                }

                // In a real application, you would fetch this data via AJAX
                // For this demo, we'll use the PHP data passed to JavaScript
                const students = <?php echo json_encode($students); ?>;
                const feeStructures = <?php echo json_encode($feeStructures); ?>;
                const outstandingFees = <?php echo json_encode($outstandingFees); ?>;

                const student = students.find(s => s.student_id == studentId);
                if (!student) return;

                const studentClass = student.class_name;
                const feesForClass = feeStructures.filter(fee => fee.class_name == studentClass);

                let options = '<option value="">Select Fee</option>';

                feesForClass.forEach(fee => {
                    // Check if this fee is outstanding for the student
                    const isOutstanding = outstandingFees.some(of =>
                        of.student_id == studentId && of.fee_id == fee.fee_id
                    );

                    if (isOutstanding) {
                        options += `<option value="${fee.fee_id}">${fee.fee_type} (Due: ${fee.due_date})</option>`;
                    }
                });

                document.getElementById('fee-options').innerHTML = options;
            }

            // Print receipt
            function printReceipt(receiptNumber) {
                // In a real application, you would fetch the receipt data via AJAX
                // For this demo, we'll use the PHP data passed to JavaScript
                const payments = <?php echo json_encode($payments); ?>;
                const payment = payments.find(p => p.receipt_number == receiptNumber);

                if (payment) {
                    const receiptContent = `
                    <div class="text-center mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold">School Fees Receipt</h2>
                        <p class="text-gray-600 text-sm">${payment.receipt_number}</p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-2 sm:gap-4 mb-2">
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Date:</p>
                                <p class="text-sm">${payment.payment_date}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-sm sm:text-base">Payment Method:</p>
                                <p class="text-sm">${payment.payment_method}</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="font-semibold text-sm sm:text-base">Student:</p>
                            <p class="text-sm">${payment.first_name} ${payment.last_name}</p>
                            <p class="text-gray-600 text-sm">${payment.class_name}</p>
                        </div>
                        
                        <div class="border-t border-b border-gray-200 py-3">
                            <p class="font-semibold text-sm sm:text-base">Fee Details:</p>
                            <p class="text-sm">${payment.fee_type}</p>
                        </div>
                        
                        <div class="mt-3 text-right">
                            <p class="font-semibold text-sm sm:text-base">Amount Paid:</p>
                            <p class="text-xl sm:text-2xl">${parseFloat(payment.amount_paid).toFixed(2)}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-3 border-t border-gray-200 text-center text-xs sm:text-sm text-gray-500">
                        <p>Thank you for your payment!</p>
                        <p>Generated on ${new Date().toLocaleString()}</p>
                    </div>
                `;

                    document.getElementById('receiptContent').innerHTML = receiptContent;
                    showModal('receiptModal');
                }
            }

            function printReceiptContent() {
                const printContent = document.getElementById('receiptContent').innerHTML;
                const originalContent = document.body.innerHTML;

                document.body.innerHTML = `
                <div class="p-4 max-w-md mx-auto">
                    ${printContent}
                </div>
                <script>
                    setTimeout(() => {
                        window.print();
                        document.body.innerHTML = \`${originalContent}\`;
                        window.location.reload();
                    }, 500);
                <\/script>
            `;
            }
        </script>
</body>
<?php include 'include/modal.php'; ?>