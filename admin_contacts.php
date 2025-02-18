<?php
require_once './config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($connect, "DELETE FROM `message` WHERE id = '$delete_id'") or die('Query failed');
    header('location:admin_contacts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/admin_style.css">
</head>

<body>
    <?php
    require_once 'admin_header.php';
    ?>

    <section class="messages">
        <h1 class="title">Admin Messages</h1>
        <div class="box-container">
            <?php
            $select_message = mysqli_query($connect, "SELECT * FROM `message`") or die('Query failed');
            if(mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {
            
            ?>
            <div class="box">
                <p>Name: <span><?php echo $fetch_message['name']; ?></span></p>
                <p>Phone Number: <span><?php echo $fetch_message['number']; ?></span></p>
                <p>E-Mail: <span><?php echo $fetch_message['email']; ?></span></p>
                <p>Message: <span><?php echo $fetch_message['message']; ?></span></p>
                <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message ?');" class="delete-btn">Delete Message</a>
            </div>
            <?php
                };
            }else{
                echo '<p class="empty">No messages yet!</p>';
            }
            ?>
        </div>
    </section>


    <!-- ------- JS Link ------- -->
    <script src="./scripts/admin_script.js"></script>
</body>

</html>