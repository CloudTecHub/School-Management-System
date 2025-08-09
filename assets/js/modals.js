//ADD CLASS MODAL SCRIPTS
// Show the modal
function openModal() {
  document.getElementById("formModal").style.display = "flex";
}

// Close the modal
function closeModal() {
  document.getElementById("formModal").style.display = "none";
  location.reload();
}

const submit = document.getElementById("submit");
submit.addEventListener('click', (f) => {
  f.preventDefault();
 const class_id = document.getElementById("class_id").value;
 const class_name = document.getElementById("class_name").value;
  // prepare to send
  const data = new FormData();
  data.append("class_id", class_id);
  data.append("class_name", class_name);
  //Send POST request
  fetch("../../public/session/class.php", {
    method: "POST",
    body: data,
  })
  // Close the modal after submission
  const success = document.getElementById("success");
  success.innerHTML = "Saved Successfully";
})




//ADD SUBJECT MODAL SCRIPTS
// Show the modal
function openAddsubjectModal() {
  document.getElementById("SubjectformModal").style.display = "flex";
}

// Close the modal
function closeSubjectModal() {
  document.getElementById("SubjectformModal").style.display = "none";
  location.reload();
}

// Handle form submission
const submitSubjectForm = document.getElementById("submitSubjectForm");
submitSubjectForm.addEventListener('click', (f) => {
  f.preventDefault();
  var subject_id = document.getElementById("subject_id").value;
  var subject_name = document.getElementById("subject_name").value;
  // prepare to send
  const data = new FormData();
  data.append("subject_id", subject_id);
  data.append("subject_name", subject_name);
  //Send POST request
  fetch("../../public/session/subject.php", {
    method: "POST",
    body: data,
  })
  // Close the modal after submission
  const subjectSubmitMessage = document.getElementById("subjectSubmitMessage");
  subjectSubmitMessage.innerHTML = "Saved Successfully";
 
})


//ADD TEst MODAL SCRIPTS
// Show the modal
function openTestModal() {
  document.getElementById("TestformModal").style.display = "flex";
}

// Close the modal
function closeTestModal() {
  document.getElementById("TestformModal").style.display = "none";
  location.reload();
}

// Handle form submission
const submitTestForm = document.getElementById("submitTestForm");
submitTestForm.addEventListener('click', (f) => {
  f.preventDefault();
  const test_id = document.getElementById("test_id").value;
  const term = document.getElementById("term").value;
  const type = document.getElementById("type").value;
  const class_nm = document.getElementById("class_nm").value;
  const start_date = document.getElementById("start_date").value;
  const end_date = document.getElementById("end_date").value;

  // prepare to send
  const data = new FormData();
  data.append("test_id", test_id);
  data.append("term", term);
  data.append("type", type);
  data.append("class_nm", class_nm);
  data.append("start_date", start_date);
  data.append("end_date", end_date);
  //Send POST request
  fetch("../../public/session/exam.php", {
    method: "POST",
    body: data,
  })
  // Close the modal after submission
  const testSubmitMessage = document.getElementById("testSubmitMessage");
  testSubmitMessage.innerHTML = "Saved Successfully";
 
})

//ASSIGN STAFF MODAL SCRIPTS
// Show the modal
function openAssignModal() {
  document.getElementById("AssignformModal").style.display = "flex";
}

// Close the modal
function closeAssignModal() {
  document.getElementById("AssignformModal").style.display = "none";
  location.reload();
}

// Handle form submission
const submitAssignForm = document.getElementById("submitAssignForm");
submitTestForm.addEventListener('click', (f) => {
  f.preventDefault();
  const staff_id = document.getElementById("staff_id").value;
  const classame = document.getElementById("classame").value;

  // prepare to send
  const data = new FormData();
  data.append("staff_id", staff_id);
  data.append("classame", classame);
  //Send POST request
  fetch("../../public/session/assign_staff.php", {
    method: "POST",
    body: data,
  })
  // Close the modal after submission
  const assignSubmitMessage = document.getElementById("assignSubmitMessage");
  assignSubmitMessage.innerHTML = "Saved Successfully";
 
})

//UPLOAD RESULTS MODAL SCRIPTS
// Show the modal
// function openResultModal() {
//   document.getElementById("openResultModal").style.display = "flex";
// }

// // Close the modal
// function closeResultModal() {
//   document.getElementById("closeResultModal").style.display = "none";
//   location.reload();
// }

// // Handle form submission
// const uploadResults = document.getElementById("uploadResults");
// uploadResults.addEventListener('click', () => {

//   const student_id = document.getElementById("student_id").value;
//   const file = document.getElementById("file").value;

//   // prepare to send
//   const data = new FormData();
//   data.append("student_id", student_id);
//   data.append("file", file);
//   //Send POST request
//   fetch("../../public/admin/result-upload/upload.php", {
//     method: "POST",
//     body: data,
//   })
//   // Close the modal after submission
//   const uploadMessage = document.getElementById("uploadMessage");
//   uploadMessage.innerHTML = "Uploaded Successfully";
 
// })


// ADD STAFF MODAL
function newStaff(){
  document.getElementById('staffFormModal').classList.remove('hidden')
}


// ADD STUDENT
function newStudent(){
  document.getElementById('studentFormModal').classList.remove('hidden')
}
//NOTIFICATION MODAL
function openNotificationModal() {
  document.getElementById('modal-form').classList.remove('hidden');
}