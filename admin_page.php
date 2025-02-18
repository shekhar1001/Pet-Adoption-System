<?php

require_once './config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/admin_style.css">
</head>

<body>
    <?php
    require_once 'admin_header.php';
    ?>

    <!-- ------- Admin Dashboard START ------- -->

    <section class="dashboard">
        <h1 class="title">Dashboard</h1>
        <div class="box-container">
            <div class="box">
                <?php
                $select_adopted = mysqli_query($connect, "SELECT * FROM `adopted`") or die('Query failed');
                $total_adopted = mysqli_num_rows($select_adopted);
                ?>
                <h3><?php echo $total_adopted; ?></h3>
                <p>Total Adoptions</p>
            </div>

            <div class="box">
                <?php
                $select_animals = mysqli_query($connect, "SELECT * FROM `animals`") or die('Query failed');
                $number_of_animals = mysqli_num_rows($select_animals);
                ?>
                <h3><?php echo $number_of_animals; ?></h3>
                <p>Total Animals</p>
            </div>

            <div class="box">
                <?php
                $select_users = mysqli_query($connect, "SELECT * FROM `users` WHERE user_type = 'user'") or die('Query failed');
                $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>Normal Users</p>
            </div>

            <div class="box">
                <?php
                $select_admins = mysqli_query($connect, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('Query failed');
                $number_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?php echo $number_of_admins; ?></h3>
                <p>Admin Users</p>
            </div>

            <div class="box">
                <?php
                $select_accounts = mysqli_query($connect, "SELECT * FROM `users`") or die('Query failed');
                $number_of_accounts = mysqli_num_rows($select_accounts);
                ?>
                <h3><?php echo $number_of_accounts; ?></h3>
                <p>Total Users</p>
            </div>
        </div>
    </section>

    <!-- ------- Admin Dashboard END ------- -->

    <!-- ------- JS Link ------- -->
    <script src="./scripts/admin_script.js"></script>
</body>

</html>