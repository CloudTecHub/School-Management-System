<!-- HEADER -->
<!-- Fixed Header -->
<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white dark:bg-gray-800 shadow flex items-center justify-between px-4 md:px-6">

  <!-- Toggle button -->
  <div class="flex items-center gap-3">
    <i class="fa fa-cloud text-sm text-gray-700 dark:text-gray-200">sms portal</i>
    <button @click="toggleDarkMode()" class="text-gray-500 dark:text-gray-300 focus:outline-none">
      <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
    </button>
  </div>
  <div> 
    <span id="countdownDisplay" class="counter"></span>
  </div>
  <!-- Center Section -->
  <div class="text-base md:text-lg text-gray-800 dark:text-white">
    <em>Welcome
      <span style="color:blueviolet;">
        <?php
        include('../../includes/database.php');
        $username = $_SESSION['username'] ?? '';
        $sql = "SELECT name FROM administrator WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'] ?? '';
        // Display the name in uppercase      
        echo strtoupper(htmlspecialchars(($name ?? '')));
        ?>!

      </span>
    </em>
  </div>

</header>

<!-- Scripts -->
<script src="../../assets/js/main.js"></script>
<script src="../../assets/js/modals.js"></script>
<script src="../../assets/js/timer.js"></script>
<script src="../../assets/js/chart.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script>
  // Function to get the theme from local storage
  function getTheme() {
    return localStorage.getItem('theme');
  }

  // Function to set the theme in local storage
  function setTheme(theme) {
    localStorage.setItem('theme', theme);
  }

  // Function to apply the theme
  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  }

  // Initially set the theme based on local storage
  let darkMode = getTheme() === 'dark';
  if (darkMode === null) {
    darkMode = false;
  }
  applyTheme(darkMode ? 'dark' : 'light');

  // Make darkMode accessible globally
  window.darkMode = darkMode;

  // Toggle dark mode function
  window.toggleDarkMode = function() {
    window.darkMode = !window.darkMode;
    applyTheme(window.darkMode ? 'dark' : 'light');
    setTheme(window.darkMode ? 'dark' : 'light');
  };

  document.querySelector('.toggle-sidebar').addEventListener('click', () => {
    document.querySelector('aside').classList.toggle('hidden');
  });
</script>
<?php include 'modals.php'; ?>