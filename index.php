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

    <section class="home">
        <div class="content">
            <h3>Best Pets.</h3>
            <p>Best Pets that you're gonna find.</p>
            <a href="about.php" class="white-btn">Discover more</a>
        </div>
    </section>

    <section class="animals">
        <h1 class="title">Our Best Pets!</h1>
        <div class="box-container">
            <?php
                $select_animals = mysqli_query($connect, "SELECT * from `animals`") or die('Query failed');
                if(mysqli_num_rows($select_animals) > 0){
                    while($fetch_animals = mysqli_fetch_assoc($select_animals)){
            ?>
            <form action="" method="POST" class="box">
                <img src="uploaded_img/<?php echo $fetch_animals['image'] ?>" alt="">
                <div class="data">Name: <span><?php echo $fetch_animals['name'] ?></span></div>
                <div class="data">Age: <span><?php echo $fetch_animals['age'] ?></span></div>
                <div class="data">Gender: <span><?php echo $fetch_animals['gender'] ?></span></div>
                <div class="data">Size: <span><?php echo $fetch_animals['size'] ?></span></div>
                <div class="data">Breed: <span><?php echo $fetch_animals['breed'] ?></span></div>
                <div class="data">Vaccinated: <span><?php echo $fetch_animals['vaccine'] ?></span></div>
                <div class="data">Address: <span><?php echo $fetch_animals['address'] ?></span></div>
                <div class="data">Description: <span><?php echo $fetch_animals['description'] ?></span></div>
                <input type="hidden" name="animal_image" value="<?php echo $fetch_animals['image']; ?>">
                <input type="hidden" name="animal_name" value="<?php echo $fetch_animals['name']; ?>">
                <input type="hidden" name="animal_age" value="<?php echo $fetch_animals['age']; ?>">
                <input type="hidden" name="animal_gender" value="<?php echo $fetch_animals['gender']; ?>">
                <input type="hidden" name="animal_size" value="<?php echo $fetch_animals['size']; ?>">
                <input type="hidden" name="animal_breed" value="<?php echo $fetch_animals['breed']; ?>">
                <input type="hidden" name="animal_vaccine" value="<?php echo $fetch_animals['vaccine']; ?>">
                <input type="hidden" name="animal_address" value="<?php echo $fetch_animals['address']; ?>">
                <input type="hidden" name="animal_description" value="<?php echo $fetch_animals['description']; ?>">
                <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
            </form>
            <?php
                    }
                }else{
                    echo '<p class="empty">No Animals has been added yet!</p>';
                }
            ?>
        </div>
    </section>

    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="./images/background2.jpg" alt="">
            </div>
            <div class="content">
                <h3>About Us!</h3>
                <p>Our carefully selected range of unique Dogs & Cats and their accessories has been sourced from Different parts of the world. </p>
                <a href="about.php" class="btn">Read more</a>
            </div>
        </div>
    </section>

    <section class="home-contact">
        <div class="content">
            <h3>Have any Questions?</h3>
            <p>Please feel free to contact us any time.</p>
            <a href="contact.php" class="white-btn">Contact Us</a>
        </div>
    </section>


    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>
</body>

</html>