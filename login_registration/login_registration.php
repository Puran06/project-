<!DOCTYPE html>
<html>
<head>
    <title>Login and Registration Form</title>
    <link rel="stylesheet" href="logreg_style.css">
    <script>
        // JavaScript function to toggle between login and registration forms
        function toggleForm() {
            var loginForm = document.getElementById("login-form");
            var registrationForm = document.getElementById("registration-form");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registrationForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                registrationForm.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="navbar-home">
            <a href="../index.html">Home</a>
        </div>
    </div>
    <h1>Login and Registration Form</h1>
    <div class="form-container" id="login-form">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="button-container">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="toggle-form-link">
            Not registered yet? <a href="javascript:void(0);" onclick="toggleForm();">Click here to register</a>.
        </div>
    </div>

    <div class="form-container" id="registration-form" style="display: none;">
        <h2>Registration</h2>
        <form action="register.php" method="POST">
            <div class="input-container">
                <label for="name">Full Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-container">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" required>
            </div>
            <div class="input-container">
                <label for="role">Role:</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="button-container">
                <input type="submit" value="Register">
            </div>
        </form>
        <div class="toggle-form-link">
            Already registered? <a href="javascript:void(0);" onclick="toggleForm();">Click here to login</a>.
        </div>
    </div>
</body>
</html>
