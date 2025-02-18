<?php

require_once './config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['send'])){
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($connect, $_POST['message']);

    $select_message = mysqli_query($connect, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die ('Query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'Message already sent!';
    }else {
        mysqli_query($connect, "INSERT INTO `message` (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$msg')") or die ('Query failed');
        $message[] = 'Message sent successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <?php require_once './header.php'; ?>

    <div class="heading">
        <h3>Contact Us!</h3>
        <p><a href="index.php">Home</a> / Contact</p>
    </div>

    <section class="contact">
        <form action="" method="post">
            <h3>Get in touch!</h3>
            <input type="text" name="name" required placeholder="Enter your Name..." class="box">
            <input type="email" name="email" required placeholder="Enter your E-Mail..." class="box">
            <input type="number" name="number" min="0" required placeholder="Enter your Number..." class="box">
            <textarea name="message" cols="30" rows="10" placeholder="Enter your Message..." class="box"></textarea>
            <input type="submit" value="Send Message" name="send" class="btn">
        </form>
    </section>

    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>
</body>

</html>