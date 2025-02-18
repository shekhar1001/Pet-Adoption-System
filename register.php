<?php
require_once './config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
    $password = mysqli_real_escape_string($connect, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($connect, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];
    $select_users = mysqli_query($connect, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('Selection failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if ($password != $cpassword) {
            $message[] = 'The Password does not match.';
        } else {
            mysqli_query($connect, "INSERT INTO `users` (name, email, phone_number, password, user_type) VALUES ('$name', '$email','$phone_number','$cpassword', '$user_type')") or die('Query faild!');
            $message[] = 'Registered successfully!';
            // header('location:login.php');
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '
                <div class="message">
                    <span>' .$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <div class="form-container">
        <form id="registrationForm" action="" method="POST">
            <h3>Register Now!</h3>
            <input type="text" name="name" placeholder="Enter your Name..." required class="box">
            <input type="email" name="email" placeholder="Enter your E-Mail..." required class="box">
            <input type="number" name="phone_number" placeholder="Enter a 10 digit Phone Number..." required class="box">
            <input type="password" name="password" placeholder="Enter your Password..." required class="box">
            <input type="password" name="cpassword" placeholder="Confirm your Password..." required class="box">
            <select name="user_type" class="box">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register Now!" class="btn">
            <p>Already have an Account ? <a href="login.php">Login Now!</a></p>
        </form>
        <script>
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            // Reset any previous error messages
            clearErrors();

            // Get form input values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone_number = document.getElementById('phone_number').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('cpassword').value;

            // Validate name (must not be empty)
            if (name.trim() === '') {
                displayError('name', 'Name is required');
                e.preventDefault();
            }

            // Validate email (must be a valid email address)
            if (!isValidEmail(email)) {
                displayError('email', 'Invalid email address');
                e.preventDefault();
            }
            if (!isValidPhone_Number(phone_number)) {
                displayError('phone_number', 'Invalid phone number');
                e.preventDefault();
            }

            // Validate password (must be at least 6 characters)
            if (password.length < 6) {
                displayError('password', 'Password must be at least 6 characters');
                e.preventDefault();
            }

            // Validate password confirmation (must match the password)
            if (password !== cpassword) {
                displayError('cpassword', 'Passwords do not match');
                e.preventDefault();
            }
        });

        // Function to display an error message for a specific field
        function displayError(fieldId, message) {
            const errorElement = document.getElementById(fieldId + '-error');
            errorElement.innerText = message;
            errorElement.style.display = 'block';
        }

        // Function to clear error messages
        function clearErrors() {
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach(function (element) {
                element.style.display = 'none';
            });
        }

        // Function to validate email address format
        function isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailPattern.test(email);
        }

        function isValidPhone_Number(phone_number) {
            // Regular expression to validate a phone number with optional separators
             const phoneRegex = /^\d{10}$/;
             return phoneRegex.test(phone_number);
            }
            
    </script>
    </div>
</body>

</html>