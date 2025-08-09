document.getElementById('checkInForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../session/checkin-process.php', true);
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('message').innerText = this.responseText;
        } else {
            document.getElementById('message').innerText = 'Error: ' + this.responseText;
        }
    };
    xhr.send(formData);
});