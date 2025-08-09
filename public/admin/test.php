<?php include('include/side-bar.php') ?>
<!-- ✅ Trigger Button -->
<button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded">Add Notification</button>

<!-- ✅ Modal Component -->
<div x-data="{ open: false }" class="relative z-50">
  <!-- Modal background -->
  <div
    x-show="open"
    x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    style="display: none;"
  >
    <!-- Modal box -->
    <div @click.away="open = false" class="bg-white w-full max-w-lg mx-auto rounded-lg shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Add Notification</h2>
      <form action="add_notification.php" method="POST">
        <textarea name="message" required rows="4" class="w-full border rounded p-2 mb-4"></textarea>
        <div class="flex justify-end space-x-2">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Send</button>
          <button type="button" @click="open = false" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
