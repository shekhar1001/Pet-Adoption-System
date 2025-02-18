<?php

require_once './config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($connect, "SELECT image FROM `adopted` WHERE id = '$delete_id'") or die ('Query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    mysqli_query($connect, "DELETE FROM `adopted` WHERE id = '$delete_id'") or die('Query failed');
    header('location:adoption.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <?php require_once './header.php'; ?>

    <div class="heading">
        <h3>Your Adoptions!</h3>
        <p><a href="index.php">Home</a> / Adoptions</p>
    </div>


    <section class="show-animals">
        <div class="box-container">
            <?php
            $select_adopted = mysqli_query($connect, "SELECT * FROM `adopted`") or die('Query failed');
            if (mysqli_num_rows($select_adopted) > 0) {
                while ($fetch_animals = mysqli_fetch_assoc($select_adopted)) {
            ?>
                    <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_animals['image'] ?>" alt="">
                        <div class="data">Name: <?php echo $fetch_animals['name'] ?></div>
                        <div class="data">Age: <?php echo $fetch_animals['age'] ?></div>
                        <div class="data">Gender: <?php echo $fetch_animals['gender'] ?></div>
                        <div class="data">Size: <?php echo $fetch_animals['size'] ?></div>
                        <div class="data">Breed: <?php echo $fetch_animals['breed'] ?></div>
                        <div class="data">Vaccinated: <?php echo $fetch_animals['vaccine'] ?></div>
                        <div class="data">Address: <?php echo $fetch_animals['address'] ?></div>
                        <div class="data">Description: <?php echo $fetch_animals['description'] ?></div>
                        <a href="adoption.php?delete=<?php echo $fetch_animals['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Animal ?')">Delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No Animals has been added yet!</p>';
            }
            ?>
        </div>
    </section>

    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>
</body>

</html>