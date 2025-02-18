<?php
require_once './config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM `users` WHERE id = '$delete_id'") or die('Query failed');
    header('location:admin_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/admin_style.css">
</head>

<body>
    <?php
    require_once 'admin_header.php';
    ?>

    <section class="users">
        <h1 class="title">User Accounts</h1>
        <div class="box-container">
            <?php
            $select_users = mysqli_query($connect, "SELECT * FROM `users`") or die('Query failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                <div class="box">
                    <p>Username: <span><?php echo $fetch_users['name']; ?></span></p>
                    <p>E-Mail: <span><?php echo $fetch_users['email']; ?></span></p>
                    <p>Phone Number: <span><?php echo $fetch_users['phone_number']; ?></span></p>
                    <p>User Type: <span style="color: <?php if ($fetch_users['user_type'] == 'admin') {echo 'var(--purple)';} ?>;"><?php echo $fetch_users['user_type']; ?></span></p>
                    <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Are you sure you want to delete this user ?');" class="delete-btn">Delete User</a>
                </div>
                <br>
            <?php
            };
            ?>
        </div>
    </section>


    <!-- ------- JS Link ------- -->
    <script src="./scripts/admin_script.js"></script>
</body>

</html>