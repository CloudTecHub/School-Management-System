<?php
// setup.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['db_host'];
    $username = $_POST['db_user'];
    $password = $_POST['db_pass'];
    $dbname = $_POST['db_name'];

    // Establish database connection
    $conn = new mysqli($host, $username, $password);

    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
        if ($conn->query($sql) === TRUE) {
            $conn->select_db($dbname);

            // Execute SQL file to create tables
            $sqlFile = __DIR__ . '/sql/install-portal.sql';
            if (file_exists($sqlFile)) {
                $sql = file_get_contents($sqlFile);
                if ($conn->multi_query($sql)) {
                    do {
                        // Process results for each query if needed
                    } while ($conn->next_result());
                } else {
                    $error = "Error executing SQL file: " . $conn->error;
                }
            } else {
                $error = 'SQL file not found.';
            }

            if (empty($error)) {
                // Create database.php file
                $dbFileContent = <<<PHP
<?php
\$host = '$host';
\$dbname = '$dbname';
\$username = '$username';
\$password = '$password';

\$conn = new mysqli(\$host, \$username, \$password, \$dbname);

if (\$conn->connect_error) {
    die("Database connection failed: " . \$conn->connect_error);
}
?>
PHP;

                file_put_contents(__DIR__ . '/includes/dbb.php', $dbFileContent);

                // Delete the setup page
                unlink(__FILE__);

                // Redirect to school-info.php
                header('Location: school-info.php');
                exit;
            }
        } else {
            $error = "Error creating database: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPAM | <?php echo strtoupper(substr(basename($_SERVER['PHP_SELF']), 0, -4)); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .message {
            color: green;
            text-align: center;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Loader Styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <h1>Setup School Management System</h1>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="" onsubmit="showLoader()">
        <label for="db_host">Database Host:</label>
        <input type="text" id="db_host" name="db_host" required><br>

        <label for="db_user">Database User:</label>
        <input type="text" id="db_user" name="db_user" required><br>

        <label for="db_pass">Database Password:</label>
        <input type="password" id="db_pass" name="db_pass"><br>

        <label for="db_name">Database Name:</label>
        <input type="text" id="db_name" name="db_name" required><br>

        <button type="submit">Setup</button>
    </form>

    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <script>
        // Function to show loader when form is submitted
        function showLoader() {
            document.getElementById('loader').style.display = 'flex';
        }
    </script>
</body>
</html>
