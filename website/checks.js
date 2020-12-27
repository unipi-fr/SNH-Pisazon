function checkpassword() {
    var lowercase = new RegExp("^(?=.*[a-z])");
    var uppercase = new RegExp("^(?=.*[A-Z])");
    var numeric = new RegExp("^(?=.*[0-9])");
    var special = new RegExp("^(?=.*[-_.?!@#$%^&*])");
    var totalLength = new RegExp("(?=.{8,})");

    var password = document.getElementById('inputPassword').value;

    var unlock = 0;
    if (lowercase.test(password)) {
        document.getElementById("lowercase").className = "alert alert-success";
        unlock++;
    } else {
        document.getElementById("lowercase").className = "alert alert-danger";
    }

    if (uppercase.test(password)) {
        unlock++;
        document.getElementById("uppercase").className = "alert alert-success";
    } else {
        document.getElementById("uppercase").className = "alert alert-danger";
    }

    if (numeric.test(password)) {
        unlock++;
        document.getElementById("numeric").className = "alert alert-success";
    } else {
        document.getElementById("numeric").className = "alert alert-danger";
    }

    if (special.test(password)) {
        unlock++;
        document.getElementById("special").className = "alert alert-success";
    } else {
        document.getElementById("special").className = "alert alert-danger";
    }

    if (totalLength.test(password)) {
        unlock++;
        document.getElementById("totalLength").className = "alert alert-success";
    } else {
        document.getElementById("totalLength").className = "alert alert-danger";
    }

    if (unlock == 5) {
        document.getElementById("saveButton").disabled = false;
    } else {
        document.getElementById("saveButton").disabled = true;
    }
}