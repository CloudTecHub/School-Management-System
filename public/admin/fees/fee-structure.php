<!-- Fee Structure Tab -->
                <div id="fee-structure" class="tab-content active">
                    <h2 class="text-2xl font-bold mb-4">Fee Structure Setup</h2>

                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-3">Add New Fee Structure</h3>
                        <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="hidden" name="action" value="add_fee_structure">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Class</label>
                                <select name="class_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Select Class</option>
                                    <?php
                                    foreach ($classes as $class): ?>
                                        <option value="<?php echo htmlspecialchars($class['class_name']); ?>">
                                            <?php echo htmlspecialchars($class['class_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fee Type</label>
                                <input type="text" name="fee_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                <input type="date" name="due_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div class="md:col-span-4">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>Add Fee Structure
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-3">Current Fee Structures</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (empty($feeStructures)): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No fee structures found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($feeStructures as $fee): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['class_name']); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['fee_type']); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($fee['amount'], 2); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fee['due_date']); ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="?delete=fee_structure&id=<?php echo $fee['fee_id']; ?>"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this fee structure?')">
                                                        <i class="fas fa-trash mr-1"></i>Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>