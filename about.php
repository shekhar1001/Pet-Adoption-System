<?php

require_once './config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <?php require_once './header.php'; ?>

    <div class="heading">
        <h3>About Us!</h3>
        <p><a href="index.php">Home</a> / About</p>
    </div>

    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="./images/background2.jpg" alt="">
            </div>
            <div class="content">
                <h3>Why choose us?</h3>
                <p>Our carefully selected range of unique Dogs & Cats and their accessories has been sourced from different part of the world. </p>
                <a href="contact.php" class="btn">Contact Us!</a>
            </div>
        </div>
    </section>

    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>
</body>

</html>