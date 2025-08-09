<?php
include '../../includes/database.php';

// Build filter conditions
$where = [];
$params = [];

// Filter by student
if (!empty($_GET['student_id'])) {
    $studentId = $conn->real_escape_string($_GET['student_id']);
    $where[] = "p.student_id = '$studentId'";
}

// Filter by date range
if (!empty($_GET['from_date'])) {
    $fromDate = $conn->real_escape_string($_GET['from_date']);
    $where[] = "DATE(p.payment_date) >= '$fromDate'";
}
if (!empty($_GET['to_date'])) {
    $toDate = $conn->real_escape_string($_GET['to_date']);
    $where[] = "DATE(p.payment_date) <= '$toDate'";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Fetch payments with filters
$payments_query = "
    SELECT p.*, s.first_name, s.last_name, s.class, fs.fee_type
    FROM payments p
    JOIN students s ON p.student_id = s.student_id
    JOIN fee_structures fs ON p.fee_id = fs.fee_id
    $whereSQL
    ORDER BY p.payment_date DESC
";
$payments_result = $conn->query($payments_query);
$payments = [];
if ($payments_result && $payments_result->num_rows > 0) {
    $payments = $payments_result->fetch_all(MYSQLI_ASSOC);
}

// Fetch students for filter dropdown
$students_query = "SELECT student_id, first_name, last_name FROM students";
$students_result = $conn->query($students_query);
$students = [];
if ($students_result && $students_result->num_rows > 0) {
    $students = $students_result->fetch_all(MYSQLI_ASSOC);
}
?>
<!-- Transaction History Tab -->
<div id="transactions" class="tab-content">
    <h2 class="text-2xl font-bold mb-4">Transaction History</h2>

    <div class="mb-4">
        <form class="flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Student</label>
                <select name="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">All Students</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo htmlspecialchars($student['student_id']); ?>"
                            <?php echo (isset($_GET['student_id']) && $_GET['student_id'] == $student['student_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="from_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="to_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
            </div>

            <div class="self-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="ml-2 text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No transactions found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['receipt_number']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo htmlspecialchars($payment['first_name'] . ' ' . $payment['last_name']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['class']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['fee_type']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($payment['amount_paid'], 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="printReceipt('<?php echo $payment['receipt_number']; ?>')"
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-print mr-1"></i>Print
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>