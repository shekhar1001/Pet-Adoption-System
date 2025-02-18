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
        <h1 class="title">Adoptions</h1>
        <div class="box-container">
        <?php
$select_users_and_adoptions = mysqli_query($connect, "SELECT users.name AS user_name, users.email, adopted.* 
    FROM `adopted` 
    INNER JOIN `users` ON adopted.user_id = users.id") or die('Query failed');
while ($row = mysqli_fetch_assoc($select_users_and_adoptions)) {
?>
<div class="box">
    <p>User Name: <span><?php echo $row['user_name']; ?></span></p>
    <p>User Email: <span><?php echo $row['email']; ?></span></p>
    <p>User Phone Number: <span><?php echo $row['phone_number']; ?></span></p>
    <p>Adopted Animal Name: <span><?php echo $row['name']; ?></span></p>
    <p>Adopted Animal Age: <span><?php echo $row['age']; ?></span></p>
    <p>Adopted Animal Gender: <span><?php echo $row['gender']; ?></span></p>
    <p>Adopted Animal Breed: <span><?php echo $row['breed']; ?></span></p>
    <p>Adopted Animal Size: <span><?php echo $row['size']; ?></span></p>
    <p>Adopted Animal Vaccine: <span><?php echo $row['vaccine']; ?></span></p>
    <p>Adopted Animal Address: <span><?php echo $row['address']; ?></span></p>
    <a href="adoption.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this adoption ?');" class="delete-btn">Delete Adoption</a>
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