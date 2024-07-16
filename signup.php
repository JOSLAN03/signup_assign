<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="container">

    <?php
        session_start();
        if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
            echo '<div class="error-messages">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            // for Clearing errors after displaying
            unset($_SESSION['errors']);
        }
        ?>

        <form action="config.php" method="POST" onsubmit="return validateForm()">

            <div class= "form-group">
                <input type="text" name="firstname" placeholder="enter your first name" id="firstname" required>
            </div>
            <div class="form-group">
                <input type="text" name="lastname" placeholder="enter last name" id="lastname" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="enter your email" id="email" required>
            </div>
            <div class="form-group">
                <input type="text" name="number" placeholder="enter your phone number" id="number" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirmpassword" placeholder=" confirm password" id="confirmpassword" required>
            </div>
            <button class="btn">SIGN UP</button>
        </form>
    </div>

    <script>
        function validateForm() {
            var firstname = document.getElementById("firstname").value;
            var lastname = document.getElementById("lastname").value;
            var number = document.getElementById("number").value;
            var password = document.getElementById("password").value;
            var confirmpassword = document.getElementById("confirmpassword").value;
            var namePattern = /^[A-Za-z]+$/;
            var pattern = /^[1-9][0-9]{9}$/;

            if (!namePattern.test(firstname)) {
                alert("Please enter a valid first name with alphabets only.");
                return false;
            }

            if (!namePattern.test(lastname)) {
                alert("Please enter a valid last name with alphabets only.");
                return false;
            }

            if (!pattern.test(number)) {
                alert("Please enter a valid 10-digit phone number starting with a digit from 1-9.");
                return false;
            }

            if (password !== confirmpassword) {
                alert("Passwords do not match.");
                return false;
            }

            if (!/(?=.*[!@#$%^&*(),.?":{}|<>]).{6,}/.test(password)) {
                alert("Password must be at least 6 characters and contain at least 2 special characters.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>