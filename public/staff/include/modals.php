<style>
  /* Modal background */
  .modal {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 14px;
    z-index: 50;
  }

  .modal-content {
    background-color: #fff;
    padding: 2rem;
    border-radius: 12px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
  }

  .modal-header {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #111827;
  }

  .modal-footer {
    text-align: right;
    margin-top: 1.5rem;
  }

  .modal-footer button {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    margin-left: 0.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
  }

  .modal-footer button:hover {
    background-color: #2563eb;
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
  }

  .form-group input {
    width: 100%;
    padding: 0.6rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-size: 14px;
  }

  .form-group input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    outline: none;
  }

  select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.6rem 2.5rem 0.6rem 1rem;
    font-size: 14px;
    color: #111827;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg fill='none' stroke='%236B7280' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.8rem center;
    background-size: 1rem;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    outline: none;
  }

  /* Font */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

  body {
    font-family: 'Inter', sans-serif;
  }

  /* Input */
  input[type="text"],
  input[type="email"],
  input[type="file"] {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: 0.2s ease;
    box-sizing: border-box;
  }

  input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    outline: none;
  }

  /* Save Button */
  button.saveBtn {
    background-color: #3b82f6;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, box-shadow 0.2s;
  }

  button.saveBtn:hover {
    background-color: #2563eb;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
  }
</style>

<!-- Modal structure -->
<div id="formModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span>Add Class</span>
      <button class="close-btn" onclick="closeModal()" style="float: right;">&times;</button>
    </div>
    <form id="userForm">
      <div class="form-group">
        <label for="Class Name">Class ID:</label>
        <input class="class-input-box" type="text" name="class_id" id="class_id" placeholder="eg. CR00000">

        <label for="Class Name">Class Name:</label>
        <input class="class-input-box" type="text" name="class_name" id="class_name">
      </div>
      <div class="modal-footer">
        <button type="button" class="saveBtn" id="submit">Submit</button>
      </div>
      <div style="font:9px bolder; color: rgb(61, 209, 140);" id="success"></div>
    </form>
  </div>
</div>

<!-- ADD SUBJECT MODAL -->
<div id="SubjectformModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span>Add Subject</span>
      <button class="close-btn" onclick="closeSubjectModal()" style="float: right;">&times;</button>
    </div>
    <form id="userForm">
      <div class="form-group">
        <div>
          <label for="Class Name">Subject Code:</label>
          <input class="input-box" type="text" name="subject_id" id="subject_id" placeholder="eg. SUBC00000">
        </div>
        <div>
          <label for="Class Teacher">Subject Name:</label>
          <input class="input-box" type="text" name="subject_name" id="subject_name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="saveBtn" id="submitSubjectForm">Submit</button>
      </div>
      <div style="font:9px bolder; color: rgb(61, 209, 140);" id="subjectSubmitMessage"></div>
    </form>
  </div>
</div>

<!-- ADD TEST MODAL -->
<div id="TestformModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span>Add Test</span>
      <button class="close-btn" onclick="closeSubjectModal()" style="float: right;">&times;</button>
    </div>
    <form id="userForm">
      <div class="form-group">
        <div>
          <label for="testId">Test ID:</label>
          <input class="input-box" type="text" name="test_id" id="test_id" placeholder="eg. TS00000">
        </div>
        <div>
          <label for="term">Term</label>
          <select name="term" id="term" required>
            <option>Select Term</option>
            <option value="First Term" name="term" id="term">First Term</option>
            <option value="Second Term" name="term" id="term">Second Term</option>
            <option value="Third Term" name="term" id="term">Third Term</option>
          </select>
        </div>
        <div>
          <label for="type">Type</label>
          <select name="type" id="type" required>
            <option>Select Type</option>
            <option value="Class Test" name="type" id="term">Class Test</option>
            <option value="Examination" name="type" id="term">Examination</option>
          </select>
        </div>
        <div>
          <label for="Class">Class</label>
          <select name="class_nm" id="class_nm" required>
            <option name="class_nm" id="class_nm">Select Class<?php
                                                              include('../../includes/database.php');
                                                              $sql = "SELECT * FROM class";
                                                              $result = $conn->query($sql);
                                                              while ($row = $result->fetch_assoc()) {
                                                                echo '<option name="class_nm" id="class_nm" value="' . $row["class_name"] . '">' . $row["class_name"] . ' </option>';
                                                              }
                                                              $conn->close(); ?></option>
          </select>
        </div>
        <div>
          <label for="startDate">Start Date:</label>
          <input class="input-box" type="date" name="start_date" id="start_date" required>
        </div>
        <div>
          <label for="endDate">Start Date:</label>
          <input class="input-box" type="date" name="end_date" id="end_date" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="saveBtn" id="submitTestForm">Submit</button>
      </div>
      <div style="font:9px bolder; color: rgb(61, 209, 140);" id="testSubmitMessage"></div>
    </form>
  </div>
</div>


<!-- ASSIGN STAFF -->
<div id="AssignformModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span>Assign Staff</span>
      <button class="close-btn" onclick="closeAssignModal()" style="float: right;">&times;</button>
    </div>
    <form id="userForm">
      <div class="form-group">
        <div>
          <div>
            <label for="staff">Staff:</label>
            <select name="staff_id" id="staff_id">
              <?php
              include('../../includes/database.php');
              $staff = $conn->query("SELECT * FROM staff");
              while ($s = $staff->fetch_assoc()) echo "<option value='{$s['staff_id']}' id='staff_id'>{$s['first_name']} {$s['last_name']}</option>";
              ?>
            </select>
          </div>
          <div>
            <label for="class">Class:</label>
            <select name="classame" id="classame">
              <?php
              include('../../includes/database.php');
              $class = $conn->query("SELECT * FROM class");
              while ($c = $class->fetch_assoc()) echo "<option value='{$c['class_name']}' id='classame'>{$c['class_name']} </option>";
              ?>
            </select>ss
          </div>
          <div class="modal-footer">
            <button type="button" class="saveBtn" id="submitAssignForm">Submit</button>
          </div>
          <div style="font:9px bolder; color: rgb(61, 209, 140);" id="assignSubmitMessage"></div>
        </div>
      </div>
    </form>
  </div>
</div>

<!--PLAN MODAL -->
<div id="openPlanModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span>Upload Results</span>
      <button class="close-btn" id="closePlanModal" onclick="closeResultModal()" style="float: right;">&times;</button>
    </div>
    <form id="userForm">
      <div class="form-group">
        <div>
          <label for="plan">Name of Plan:</label>
          <input class="input-box" type="text" name="plan" id="plan" placeholder="">
        </div>
        <div>
          <label for="date">Date:</label>
          <input class="input-box" type="date" name="date" id="date">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="saveBtn" id="submitPlan">Submit</button>
      </div>
      <div style="font:9px bolder; color: rgb(61, 209, 140);" id="planMessage"></div>
    </form>
  </div>
</div>
<?php
include('../../includes/database.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $target_dir = "../../resultroom/";
    $target_file = $target_dir . basename($_FILES['file']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_type = array("pdf", "png", "jpeg", "gif");
    if (!in_array($file_type, $allowed_type)) {
      echo "Sorry, only PDFs and images are allowed.";
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $student_id = $_REQUEST["student_id"];
        $filename = $_FILES["file"]["name"];
        $filesize = $_FILES["file"]["size"];
        $filetype = $_FILES["file"]["type"];

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO results (student_id, filename, filesize, filetype) VALUES ('$student_id', '$filename', $filesize, '$filetype')";
        if ($conn->query($sql) === TRUE) {
          header("Location: index.php");
          exit();
        } else {
          echo "Sorry, there was an error while trying to upload the file: " . $conn->error;
        }
        $conn->close();
      } else {
        echo "Oops, there was an error uploading the file.";
      }
    }
  } else {
    echo "No file was uploaded.";
  }
}
?>

<!-- Modal Trigger Button -->
<!-- <button id="openModalBtn" class="btn btn-primary mt-4">Upload Student Results</button> -->

<!-- Modal -->
<div id="uploadmodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 style="font-size:20px; margin-bottom:20px;">Upload Student Results</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="student_id" style="font-family:monospace;">Student ID</label>
      <input type="text" name="student_id" required style="width: 100%; margin-bottom: 10px;">
      <label for="file" style="font-family:monospace;">Select File</label>
      <input type="file" name="file" id="file" required style="width: 100%; margin-bottom: 15px;">
      <button type="submit" class="saveBtn">Upload</button>
    </form>
  </div>
</div>

<!-- Modal CSS -->
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    position: relative;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  .close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 24px;
    cursor: pointer;
    color: #888;
  }

  .close:hover {
    color: #000;
  }
</style>

<!-- Modal JavaScript -->
<script>
  document.getElementById("openmodalBtn").onclick = function() {
    document.getElementById("uploadmodal").style.display = "block";
  };

  document.querySelector(".close").onclick = function() {
    document.getElementById("uploadmodal").style.display = "none";
  };

  window.onclick = function(event) {
    if (event.target == document.getElementById("uploadmodal")) {
      document.getElementById("uploadmodal").style.display = "none";
    }
  };
</script>



<!-- Add Admin -->
<div id="adminFormModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">

    <!-- Close Button -->
    <button
      onclick="document.getElementById('adminFormModal').classList.add('hidden')"
      class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl">
      &times;
    </button>

    <!-- Form -->
    <form action="../session/admin.php" method="post">
      <h1 class="text-xl font-semibold mb-4">Add Administrator</h1>

      <div class="grid grid-cols-1 gap-4">
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Admin ID</label>
          <input type="text" name="administrator_id" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
          <select name="role" class="w-full border rounded px-3 py-2" required>
            <option value="">Select Role</option>
            <option value="administrator">administrator</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="conpassword" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="text-right mt-4">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Add Staff -->

<div id="staffFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
<div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">

    <!-- Close Button -->


    <!-- Staff Form -->
    <form action="../session/staff.php" method="post" class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">New Staff</h1>

      <!-- Personal Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
        <button
          onclick="document.getElementById('staffFormModal').classList.add('hidden')"
          class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
          &times;
        </button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Staff ID</label>
            <input type="text" name="staff_id" placeholder="STF0000000" readonly required class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Gender</label>
            <select name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option>Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium">Surname</label>
            <input type="text" name="first_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Middle Name</label>
            <input type="text" name="mid_name" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Last Name</label>
            <input type="text" name="last_name" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Date of Birth</label>
            <input type="date" name="dob" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Phone Number</label>
            <input type="text" name="number" placeholder="233 xxx xxx xxx" minlength="12" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div class="md:col-span-2">
            <label class="block mb-1 font-medium">NHIS Membership No.</label>
            <input type="text" name="healthinsur" placeholder="XXXXXXXX" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>

      <!-- Address -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Address</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Current Address</label>
            <input type="text" name="curaddress" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block mb-1 font-medium">City Name</label>
            <input type="text" name="cityname" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>

      <!-- Employment Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Employment Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block mb-1 font-medium">Qualification</label>
            <input type="text" name="qualification" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block mb-1 font-medium">Join Date</label>
            <input type="date" name="join_date" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block mb-1 font-medium">Current Position</label>
            <input type="text" name="curr_position" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>

      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 font-medium">Select Role</label>
            <select name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option>Select</option>
              <option value="staff">staff</option>
            </select>
          </div>

          <div>
            <label class="block mb-1 font-medium">Username</label>
            <input type="text" name="username" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password" id="password" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div>
            <label class="block mb-1 font-medium">Confirm Password</label>
            <input type="password" name="conpassword" id="confirm_password" minlength="4" maxlength="15" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="showc(); btnShow2()">Toggle</button>
            <div id="password_strength" class="text-xs text-gray-500 mt-1"></div>
          </div>
        </div>
      </section>

      <!-- Submit -->
      <div class="text-right pt-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ADD STUDENTS -->

<div id="studentFormModal"
class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
<div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow-lg p-6 relative m-4 sm:m-6">
    <!-- Full Form -->
    <form action="../session/student.php" method="post" class="space-y-8">
      <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white">New Student</h1>
      <!-- Personal Details -->
      <div class="grid md:grid-cols-2 gap-4">
        <section>
          <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Personal Details</h2>
          <button
            onclick="document.getElementById('studentFormModal').classList.add('hidden')"
            class="absolute top-20 right-3 text-red-400 hover:text-gray-800 text-xl">
            &times;
          </button>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1">Student ID</label>
              <input type="text" name="student_id" placeholder="Auto-Generate" readonly required
                class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Gender</label>
              <select name="gender" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <div>
              <label class="block font-medium mb-1">First Name</label>
              <input type="text" name="first_name" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Middle Name</label>
              <input type="text" name="mid_name" placeholder="Optional"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Last Name</label>
              <input type="text" name="last_name" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Date of Birth</label>
              <input type="date" name="dob" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Phone Number</label>
              <input type="text" name="number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
              <label class="block font-medium mb-1">Email</label>
              <input type="email" name="email" placeholder="Optional"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="md:col-span-2">
              <label class="block font-medium mb-1">Class</label>
              <select name="class" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                <option>Select Class</option>
                <?php
                include('../../includes/database.php');
                $sql = "SELECT * FROM class";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row["class_name"] . '">' . $row["class_name"] . '</option>';
                }
                $conn->close();
                ?>
              </select>
            </div>

            <div class="md:col-span-2">
              <label class="block font-medium mb-1">NHIS Membership No.</label>
              <input type="text" name="healthinsur" placeholder="XXXXXXXX" minlength="8" maxlength="8" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            </div>
          </div>
      </div>
      </section>

      <!-- Address -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Address</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Current Address</label>
            <input type="text" name="curaddress" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">City Name</label>
            <input type="text" name="cityname" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>


      <!-- Parent Details -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Parent Details</h2>
        <div class="grid md:grid-cols-3 gap-4">
          <div>
            <label class="block font-medium mb-1">First Name</label>
            <input type="text" name="parent_first_name" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Middle Name</label>
            <input type="text" name="parent_mid_name" placeholder="Optional"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Last Name</label>
            <input type="text" name="parent_last_name" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="parent_email" placeholder="Optional"
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Phone Number</label>
            <input type="text" name="parent_number" placeholder="0xxxxxxxxx" minlength="9" maxlength="10" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>
        </div>
      </section>


      <!-- Account Details -->
      <section>
        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Account Details</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Select Role</label>
            <select name="role" required class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
              <option>Select</option>
              <option value="student">student</option>
            </select>
          </div>

          <div>
            <label class="block font-medium mb-1">Username</label>
            <input type="text" name="username" autocomplete="username" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block font-medium mb-1">Password</label>
            <input type="password" name="password" id="password" minlength="4" maxlength="15" autocomplete="new-password" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="show(); btnShow()">Toggle</button>
          </div>

          <div>
            <label class="block font-medium mb-1">Confirm Password</label>
            <input type="password" name="conpassword" id="confirm_password" minlength="4" maxlength="15" autocomplete="new-password" required
              class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="button" class="text-sm text-blue-500 mt-1" onclick="showc(); btnShow2()">Toggle</button>
            <div id="password_strength" class="text-xs text-gray-500 mt-1"></div>
          </div>
        </div>
      </section>


      <!-- Submit -->
      <div class="text-center">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Save
        </button>
      </div>

    </form>
  </div>
</div>
<!-- Trigger Button -->


<!-- Modal -->

