<?php

require_once './config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
if(isset($_POST['adopt_animal'])){
    $animal_name = $_POST['animal_name'];
    $animal_age = $_POST['animal_age'];
    $animal_gender = $_POST['animal_gender'];
    $animal_breed = $_POST['animal_breed'];
    $animal_size = $_POST['animal_size'];
    $animal_vaccine = $_POST['animal_vaccine'];
    $animal_image = $_POST['animal_image'];
    $animal_address = $_POST['animal_address'];
    $animal_description = $_POST['animal_description'];

    $check_adoptions = mysqli_query($connect, "SELECT * FROM `adopted` WHERE name = '$animal_name' AND user_id = '$user_id'") or die ('Query failed');

    if(mysqli_num_rows($check_adoptions) > 0){
        $message[] = 'You have already adopted this animal';
    }else{
        mysqli_query($connect, "INSERT INTO `adopted`(user_id, name, age, gender, breed, size, vaccine, image, address, description) VALUES ('$user_id', '$animal_name', '$animal_age', '$animal_gender', '$animal_breed', '$animal_size', '$animal_vaccine', '$animal_image', '$animal_address', '$animal_description')") or die ('Query failed');
        $message[] = 'Animal has been adopted!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Pets</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <?php require_once './header.php'; ?>
    <h1 class="title">Junior Animals<h1>
    <section class="show-animals">
        <div class="box-container">
            <?php
            $select_juniors = mysqli_query($connect, "SELECT * FROM `animals` WHERE age <3") or die('Query failed');
            if (mysqli_num_rows($select_juniors) > 0) {
                while ($fetch_juniors = mysqli_fetch_assoc($select_juniors)) {
            ?>
                    <form action="" method="POST" class="box">
                        <img src="uploaded_img/<?php echo $fetch_juniors['image'] ?>" alt="">
                        <div class="data">Name: <span><?php echo $fetch_juniors['name'] ?></span></div>
                        <div class="data">Age: <span><?php echo $fetch_juniors['age'] ?></span></div>
                        <div class="data">Gender: <span><?php echo $fetch_juniors['gender'] ?></span></div>
                        <div class="data">Size: <span><?php echo $fetch_juniors['size'] ?></span></div>
                        <div class="data">Breed: <span><?php echo $fetch_juniors['breed'] ?></span></div>
                        <div class="data">Vaccinated: <span><?php echo $fetch_juniors['vaccine'] ?></span></div>
                        <div class="data">Address: <span><?php echo $fetch_juniors['address'] ?></span></div>
                        <div class="data">Description: <span><?php echo $fetch_juniors['description'] ?></span></div>
                        <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
                        
                </form>
            <?php
                }
            } else {
                echo '<p class="empty">No Junior Animals!</p>';
            }
            ?>
        </div>
    </section>
    <h1 class="title">Adult Animals<h1>
    <section class="show-animals">
        <div class="box-container">
            <?php
            $select_adult = mysqli_query($connect, "SELECT * FROM `animals` WHERE age>=3&&age<=7 ") or die('Query failed');
            if (mysqli_num_rows($select_adult) > 0) {
                while ($fetch_adult = mysqli_fetch_assoc($select_adult)) {
            ?>
                    <form action="" method="POST" class="box">
                        <img src="uploaded_img/<?php echo $fetch_adult['image'] ?>" alt="">
                        <div class="data">Name: <span><?php echo $fetch_adult['name'] ?></span></div>
                        <div class="data">Age: <span><?php echo $fetch_adult['age'] ?></span></div>
                        <div class="data">Gender: <span><?php echo $fetch_adult['gender'] ?></span></div>
                        <div class="data">Size: <span><?php echo $fetch_adult['size'] ?></span></div>
                        <div class="data">Breed: <span><?php echo $fetch_adult['breed'] ?></span></div>
                        <div class="data">Vaccinated: <span><?php echo $fetch_adult['vaccine'] ?></span></div>
                        <div class="data">Address: <span><?php echo $fetch_adult['address'] ?></span></div>
                        <div class="data">Description: <span><?php echo $fetch_adult['description'] ?></span></div>
                        <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
                </form>
            <?php
                }
            } else {
                echo '<p class="empty">No Adult Animals!</p>';
            }
            ?>
        </div>
    </section>
    
    <h1 class="title">Senior Animals<h1>
    <section class="show-animals">
        <div class="box-container">
            <?php
            $select_seniors = mysqli_query($connect, "SELECT * FROM `animals` WHERE age > 7") or die('Query failed');
            if (mysqli_num_rows($select_seniors) > 0) {
                while ($fetch_seniors = mysqli_fetch_assoc($select_seniors)) {
            ?>
                    <form action="" method="POST" class="box">
                        <img src="uploaded_img/<?php echo $fetch_seniors['image'] ?>" alt="">
                        <div class="data">Name: <span><?php echo $fetch_seniors['name'] ?></span></div>
                        <div class="data">Age: <span><?php echo $fetch_seniors['age'] ?></span></div>
                        <div class="data">Gender: <span><?php echo $fetch_seniors['gender'] ?></span></div>
                        <div class="data">Size: <span><?php echo $fetch_seniors['size'] ?></span></div>
                        <div class="data">Breed: <span><?php echo $fetch_seniors['breed'] ?></span></div>
                        <div class="data">Vaccinated: <span><?php echo $fetch_seniors['vaccine'] ?></span></div>
                        <div class="data">Address: <span><?php echo $fetch_seniors['address'] ?></span></div>
                        <div class="data">Description: <span><?php echo $fetch_seniors['description'] ?></span></div>
                        <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
                </form>
            <?php
                }
            } else {
                echo '<p class="empty">No Senior Animals!</p>';
            }
            ?>
        </div>
    </section>
    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>

</body>
</html>