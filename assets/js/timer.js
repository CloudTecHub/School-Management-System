 // Total seconds for the timer (5 minutes)
 var totalSeconds = 300;

 // Function to update countdown and logout user
 function updateCountdown() {
   var hours = Math.floor(totalSeconds / 3600);
   var minutes = Math.floor((totalSeconds % 3600) / 60);
   var seconds = totalSeconds % 60;

   // Add leading zeros if needed
   hours = String(hours).padStart(2, "0");
   minutes = String(minutes).padStart(2, "0");
   seconds = String(seconds).padStart(2, "0");

   // Update countdown element
   var countdownElement = document.getElementById("countdownDisplay");
   countdownElement.textContent = hours + ":" + minutes + ":" + seconds;

   // Decrease totalSeconds
   totalSeconds--;

   // Check if countdown has reached 0
   if (totalSeconds < 0) {
     // Redirect or log out the user here
     window.location.href = "../../logout.php"; // Replace with your logout URL
   } else {
     // Call updateCountdown function again after 1 second
     setTimeout(updateCountdown, 1000);
   }
 }

 // Function to reset the timer when user activity detected
 function resetTimer() {
   totalSeconds = 300; // Reset the timer back to 5 minutes
 }

 // Start the countdown
 updateCountdown();

  //Event listeners to reset the timer on user activity
  // document.addEventListener('mousemove', resetTimer);
  // document.addEventListener('keypress', resetTimer);