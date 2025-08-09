<?php
// school-info.php
include '../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_name = $_POST['school_name'];
    $type_of_institution = $_POST['type_of_institution'];
    $address = $_POST['address'];
    $enrollment_capacity = $_POST['enrollment_capacity'];
    $facilities = $_POST['facilities'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $academic_year = $_POST['academic_year'];
    $color_scheme = $_POST['color_scheme'];
    $image_path = 'uploads/' . basename($_FILES['school_image']['name']);

    if (move_uploaded_file($_FILES['school_image']['tmp_name'], $image_path)) {
        $stmt = $conn->prepare(
            "INSERT INTO school_details (school_name, type_of_institution, address, enrollment_capacity, facilities, email, contact, academic_year, color_scheme, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
                school_name = VALUES(school_name), 
                type_of_institution = VALUES(type_of_institution), 
                address = VALUES(address), 
                enrollment_capacity = VALUES(enrollment_capacity), 
                facilities = VALUES(facilities), 
                email = VALUES(email), 
                contact = VALUES(contact), 
                academic_year = VALUES(academic_year), 
                color_scheme = VALUES(color_scheme), 
                image_path = VALUES(image_path)"
        );
        $stmt->bind_param('sssisissss', $school_name, $type_of_institution, $address, $enrollment_capacity, $facilities, $email, $contact, $academic_year, $color_scheme, $image_path);

        if ($stmt->execute()) {
            $message = "School details saved successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Failed to upload image.";
    }
}

$result = $conn->query("SELECT * FROM school_details LIMIT 1");
$school_details = $result->fetch_assoc();
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
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        input[type="text"], input[type="number"], input[type="email"], input[type="color"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message, .error {
            text-align: center;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        img {
            max-width: 200px;
            display: block;
            margin: 15px auto;
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
    <h1>School Information Setup</h1>

    <?php if (!empty($message)) : ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <div class="error">Error: <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" onsubmit="showLoader()">
        <label for="school_name">School Name:</label>
        <input type="text" id="school_name" name="school_name" value="<?= htmlspecialchars($school_details['school_name'] ?? '') ?>" required><br>

        <label for="type_of_institution">Type of Institution:</label>
        <input type="text" id="type_of_institution" name="type_of_institution" value="<?= htmlspecialchars($school_details['type_of_institution'] ?? '') ?>" required><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?= htmlspecialchars($school_details['address'] ?? '') ?></textarea><br>

        <label for="enrollment_capacity">Enrollment Capacity:</label>
        <input type="number" id="enrollment_capacity" name="enrollment_capacity" value="<?= htmlspecialchars($school_details['enrollment_capacity'] ?? '') ?>" required><br>

        <label for="facilities">Facilities:</label>
        <textarea id="facilities" name="facilities" required><?= htmlspecialchars($school_details['facilities'] ?? '') ?></textarea><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($school_details['email'] ?? '') ?>" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($school_details['contact'] ?? '') ?>" required><br>

        <label for="academic_year">Academic Year:</label>
        <input type="text" id="academic_year" name="academic_year" value="<?= htmlspecialchars($school_details['academic_year'] ?? '') ?>" required><br>

        <label for="color_scheme">Color Scheme:</label>
        <input type="color" id="color_scheme" name="color_scheme" value="<?= htmlspecialchars($school_details['color_scheme'] ?? '#ffffff') ?>" required><br>

        <label for="school_image">School Image:</label>
        <input type="file" id="school_image" name="school_image" accept="image/*"><br>

        <?php if (!empty($school_details['image_path'])) : ?>
            <img src="<?= htmlspecialchars($school_details['image_path']) ?>" alt="School Image"><br>
        <?php endif; ?>

        <button type="submit">Save</button>
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
