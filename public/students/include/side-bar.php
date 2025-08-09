<?php
session_start();
// error_reporting(0);
// @ini_set('display_error', 0);
if (!isset($_SESSION['username']) && ($_SESSION['role'] !== 'student')) {
  header("Location:../../index.php");
}
include('../../templates/loader.php');
?>
<!DOCTYPE html>
<html lang="en" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || false,
    toggleDarkMode() {
      this.darkMode = !this.darkMode;
      localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
      if (this.darkMode) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  }" :class="{ 'dark': darkMode }" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo strtoupper(substr(basename($_SERVER['PHP_SELF']), 0, -4)); ?></title>
  <link rel="icon" href="../../../assets/images/favicon.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen flex">
  <!-- Sidebar -->

  <aside
  x-data="{
    sidebarCollapsed: window.innerWidth < 768,
    dropdowns: {
      results: false,
      test: false,
      attendance: false,
      notification: false,
      plan: false,
      reports: false
    },
    toggleDropdown(id) {
      this.dropdowns[id] = !this.dropdowns[id];
    }
  }"
  @resize.window="sidebarCollapsed = window.innerWidth < 768"
  class="fixed bg-white dark:bg-gray-800 shadow-md h-screen p-2 overflow-y-auto transition-all duration-300 ease-in-out"
  :class="{ 'w-20': sidebarCollapsed, 'w-64': !sidebarCollapsed }"
  x-init="$watch('sidebarCollapsed', value => { if(value) dropdowns = {} })"
>
<br><br>
  <!-- Toggle -->
  <div class="flex justify-start px-2 mt-4">
    <button @click="sidebarCollapsed = !sidebarCollapsed" class="text-gray-500">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <!-- Navigation -->
  <nav class="space-y-1 mt-4">
    <!-- Dashboard -->
    <a href="student-dashboard.php" class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-medium" :title="sidebarCollapsed ? 'Dashboard' : ''">
      <i class="fas fa-tachometer-alt text-lg text-purple-500"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
    </a>

    <!-- Dropdown Menus -->
    <template x-for="[key, icon, label, links] of [
      ['results', 'fa-square-poll-vertical', 'Results', [['view-result.php','View']]],
      ['test', 'fa-clipboard', 'Test', [['view.php','View']]],
      ['attendance', 'fa-check', 'Attendance', [['#','My Attendance']]],
      ['notification', 'fa-bell', 'Notification', [['notification.php','View']]],
      ['plan', 'fa-running', 'Plan', [['#','Add','openmodalBtn'], ['#','View']]],
      ['reports', 'fa-ban', 'Reports', [['#','Report Staff']]]
    ]" :key="key">
      <div>
        <button @click="toggleDropdown(key)" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? label : ''">
          <div class="flex items-center space-x-3">
            <i :class="`fas ${icon} text-sm text-purple-500`"></i>
            <span x-show="!sidebarCollapsed" class="whitespace-nowrap" x-text="label"></span>
          </div>
          <i x-show="!sidebarCollapsed" class="fas fa-chevron-down text-xs text-gray-500" :class="{ 'rotate-180': dropdowns[key] }"></i>
        </button>
        <div x-show="dropdowns[key] && !sidebarCollapsed" x-transition class="ml-10 mt-1 text-sm space-y-1 text-blue-600">
          <template x-for="[url, name, action] of links" :key="name">
            <a
              :href="url"
              class="block px-2 py-1 hover:underline"
              :onclick="action ? `${action}(); return false;` : null"
              x-text="name"
            ></a>
          </template>
        </div>
      </div>
    </template>

    <!-- Settings -->
    <a href="settings.php" class="flex items-center space-x-3 px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm" :title="sidebarCollapsed ? 'Settings' : ''">
      <i class="fas fa-cogs text-lg text-purple-500"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Settings</span>
    </a>

    <!-- Logout -->
    <a href="../session/logout.php" class="flex items-center space-x-3 px-3 py-2 text-red-600 hover:text-red-800 dark:hover:text-red-400 text-sm" :title="sidebarCollapsed ? 'Logout' : ''">
      <i class="fas fa-sign-out-alt text-lg"></i>
      <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Logout</span>
    </a>
  </nav>
</aside>


  <?php require_once('modals.php'); ?>

  <script>
    
  </script>