<?php

session_start();

// Database connection
include('../../includes/database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle login for any user type (admin, staff, student)
function loginUser($conn, $username, $password, $role) {
    $query = "";
    $redirectUrl = "";

    switch ($role) {
        case 'administrator':
            $query = "SELECT * FROM administrator WHERE username = ?";
            $redirectUrl = "../admin/admin-dashboard.php";
            break;
        case 'student':
            $query = "SELECT * FROM students WHERE (username = ? OR email = ? OR student_id = ?)";
            $redirectUrl = "../students/student-dashboard.php";
            break;
        case 'staff':
            $query = "SELECT * FROM staff WHERE (username = ? OR email = ? OR staff_id = ?)";
            $redirectUrl = "../staff/staff-dashboard.php";
            break;
        default:
            return false; // Role not recognized
    }

    $stmt = $conn->prepare($query);
    if ($role === 'student') {
        $stmt->bind_param("sss", $username, $username, $username); // For student: check username, email, or student_id
    } else {
        $stmt->bind_param("s", $username); // For admin and staff: check username or staff_id
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $role;

            // Store staff_id in session for staff
            if ($role === 'staff') {
                $_SESSION['staff_id'] = $row['staff_id']; // Assuming staff_id is in the staff table
            }

            header("Location: $redirectUrl");
            exit();
        }
    }
    return false;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Try to log in as admin
        if (loginUser($conn, $username, $password, 'administrator')) {
            exit();
        }

        // Try to log in as student
        if (loginUser($conn, $username, $password, 'student')) {
            exit();
        }

        // Try to log in as staff
        if (loginUser($conn, $username, $password, 'staff')) {
            exit();
        }

        // If no match was found
        header("Location: ../../index.php");
        exit();
    }
}

$conn->close();

?>