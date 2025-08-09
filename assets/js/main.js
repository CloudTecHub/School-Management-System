
// SHOW/HIDE DASHBOARD PANEL
const sidebar = document.querySelector(".main-bar");
const toggleButton = document.querySelector(".toggle-sidebar");
const elementsToToggle = [
  document.querySelector(".tab"),
  document.querySelector(".stats"),
  document.querySelector(".school-name")
];

toggleButton.addEventListener("click", () => {
  sidebar.classList.toggle("none");
  elementsToToggle.forEach((el) => el.classList.toggle('tabNone'));
  console.log("done");
});

// PASSWORD MATCH AND VISIBILITY TOGGLE
function togglePasswordVisibility(inputId) {
  const input = document.getElementById(inputId);
  input.type = input.type === "text" ? "password" : "text";
}

function toggleButtonText(buttonId) {
  const button = document.getElementById(buttonId);
  button.textContent = button.textContent === "Hide" ? "Show" : "Hide";
}

// Show password toggle for both password and confirm password fields
document.getElementById("btnshow1").addEventListener("click", () => {
  togglePasswordVisibility("password");
  toggleButtonText("btnshow1");
});
document.getElementById("btnshow2").addEventListener("click", () => {
  togglePasswordVisibility("confirm_password");
  toggleButtonText("btnshow2");
});

// Check if passwords match
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm_password");
const passwordStrengthDiv = document.getElementById("password_strength");

confirmPasswordInput.addEventListener("input", () => {
  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  passwordStrengthDiv.textContent = password === confirmPassword ? "Password match" : "Password do not match";
});

// Modal functionality
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal_container");
  const closeModal = document.getElementById("close_modal");

  document.querySelectorAll(".edit").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const studentId = link.getAttribute("data-id");

      fetch(`?action=fetch_student&id=${studentId}`)
        .then((response) => response.json())
        .then((data) => {
          Object.entries(data).forEach(([key, value]) => {
            const field = document.getElementById(key);
            if (field) field.value = value;
          });

          modal.classList.add("show");
        });
    });
  });

  closeModal.addEventListener("click", () => {
    modal.classList.remove("show");
  });
});


document.getElementById("openModalBtn").onclick = function () {
  document.getElementById("uploadModal").style.display = "block";
};

document.querySelector(".close").onclick = function () {
  document.getElementById("uploadModal").style.display = "none";
};

window.onclick = function (event) {
  if (event.target == document.getElementById("uploadModal")) {
    document.getElementById("uploadModal").style.display = "none";
  }
};