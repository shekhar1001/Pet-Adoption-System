<?php

require_once './config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_animal'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $breed = $_POST['breed'];
    $size = $_POST['size'];
    $vaccine = $_POST['vaccine'];
    $image = $_FILES['image']['name'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './uploaded_img/' . $image;

    $select_animal_name = mysqli_query($connect, "SELECT name FROM `animals` WHERE name = '$name'") or die('Query failed');

    if (mysqli_num_rows($select_animal_name) > 0) {
        $message[] = 'Animal name already added';
    } else {
        $add_animal_query = mysqli_query($connect, "INSERT INTO `animals` (name, age, gender, breed, size, vaccine, image, address, description) VALUES ('$name', '$age', '$gender', '$breed', '$size', '$vaccine', '$image', '$address', '$description')") or die('Query failed');

        if ($add_animal_query) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Animal added successfully';
            }
        } else {
            $message[] = 'Animal could not be added';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($connect, "SELECT image FROM `animals` WHERE id = '$delete_id'") or die ('Query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($connect, "DELETE FROM `animals` WHERE id = '$delete_id'") or die('Query failed');
    header('location:admin_products.php');
}

if(isset($_POST['update_animal'])) {
    $update_animal_id = $_POST['update_animal_id'];
    $update_name = $_POST['update_name'];
    $update_age = $_POST['update_age'];
    $update_gender = $_POST['update_gender'];
    $update_size = $_POST['update_size'];
    $update_breed = $_POST['update_breed'];
    $update_vaccine = $_POST['update_vaccine'];
    $update_address = $_POST['update_address'];
    $update_description = $_POST['update_description'];

    mysqli_query($connect, "UPDATE `animals` SET name = '$update_name', age = '$update_age', gender = '$update_gender', breed = '$update_breed', vaccine = '$update_vaccine', address = '$update_address', description = '$update_description' WHERE id = '$update_animal_id'") or die ('Query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if(!empty($update_image)){
        if($update_image_size > 2000000){
            $message[] = 'Image size is too large';
        }else{
            mysqli_query($connect, "UPDATE `animals` SET image = '$update_image' WHERE id = '$update_animal_id'") or die ('Query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('./uploaded_img/' . $update_old_image);
        }
    }

    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Animal</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/admin_style.css">
</head>

<body>
    <?php
    require_once 'admin_header.php';
    ?>

    <!-- ------- Animals CRUD START ------- -->

    <section class="add-animals">
        <h1 class="title">Add some Pets</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add a Pet</h3>
            <input type="text" class="box" name="name" placeholder="Enter animal name..." required>
            <input type="text" class="box" name="breed" placeholder="Enter animal breed..." required>
            <label for="gender">Gender</label>
            <select class="box" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <label for="size">Size</label>
            <select class="box" name="size" required>
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="big">Big</option>
            </select>
            <label for="vaccine">Vaccinated</label>
            <select class="box" name="vaccine" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <input type="number" class="box" min="1" max="20" name="age" placeholder="Enter animal age..." required>
            <input type="file" class="box" name="image" accept="image/jpg, image/jpeg, image/png" required>
            <textarea name="description" cols="30" rows="10" class="box" placeholder="Enter animal description..."></textarea>
            <input type="text" class="box" name="address" placeholder="Enter animal address..." required>
            <input type="submit" value="Add an Animal" name="add_animal" class="btn">
        </form>
    </section>

    <!-- ------- Animals CRUD END ------- -->

    <!-- ------- Show animals START ------- -->

    <section class="show-animals">
        <div class="box-container">
            <?php
            $select_animals = mysqli_query($connect, "SELECT * FROM `animals`") or die('Query failed');
            if (mysqli_num_rows($select_animals) > 0) {
                while ($fetch_animals = mysqli_fetch_assoc($select_animals)) {
            ?>
                    <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_animals['image'] ?>" alt="">
                        <div class="data"><span>Name:</span> <?php echo $fetch_animals['name'] ?></div>
                        <div class="data"><span>Age:</span> <?php echo $fetch_animals['age'] ?></div>
                        <div class="data"><span>Gender:</span> <?php echo $fetch_animals['gender'] ?></div>
                        <div class="data"><span>Size:</span> <?php echo $fetch_animals['size'] ?></div>
                        <div class="data"><span>Breed:</span> <?php echo $fetch_animals['breed'] ?></div>
                        <div class="data"><span>Vaccinated:</span> <?php echo $fetch_animals['vaccine'] ?></div>
                        <div class="data"><span>Address:</span> <?php echo $fetch_animals['address'] ?></div>
                        <div class="data"><span>Description:</span> <?php echo $fetch_animals['description'] ?></div>
                        <a href="admin_products.php?update=<?php echo $fetch_animals['id']; ?>" class="option-btn">Update Info</a>
                        <a href="admin_products.php?delete=<?php echo $fetch_animals['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Animal ?')">Delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No Animals has been added yet</p>';
            }
            ?>
        </div>
    </section>

    <section class="edit-animal-form">
        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($connect, "SELECT * FROM `animals` WHERE id = '$update_id'") or die('Query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_animal_id" value="<?php echo $fetch_update['id'] ?>">

                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image'] ?>">

                        <img src="uploaded_img/<?php echo $fetch_update['image'] ?>" alt="">
                        <br>
                        <label for="update_name">Name</label>
                        <input type="text" name="update_name" class="box" value="<?php echo $fetch_update['name'] ?>" required placeholder="Enter Animal Name...">

                        <label for="update_age">Age</label>
                        <input type="number" name="update_age" min="1" max="20" class="box" value="<?php echo $fetch_update['age'] ?>" required placeholder="Enter Animal Age...">

                        <label for="update_gender">Gender</label>
                        <select class="box" name="update_gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        <label for="update_size">Size</label>
                        <select class="box" name="update_size" required>
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="big">Big</option>
                        </select>

                        <label for="update_breed">Breed</label>
                        <input type="text" name="update_breed" class="box" value="<?php echo $fetch_update['breed'] ?>" required placeholder="Enter Animal Breed...">

                        <label for="update_vaccine">Vaccinated</label>
                        <select class="box" name="update_vaccine" required>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>

                        <label for="update_address">Address</label>
                        <input type="text" name="update_address" class="box" value="<?php echo $fetch_update['address'] ?>" required placeholder="Enter Animal Address...">

                        <label for="update_description">Description</label>
                        <input type="text" name="update_description" class="box" value="<?php echo $fetch_update['description'] ?>" required placeholder="Enter Animal Description...">

                        <label for="update_image">Upload an Image</label>
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">

                        <input type="submit" value="Update" name="update_animal" class="btn">

                        <input type="reset" value="Cancel" id="close-update" class="option-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-animal-form").style.display = "none";</script>';
        }
        ?>
    </section>

    <!-- ------- Show animals END ------- -->

    <!-- ------- JS Link ------- -->
    <script src="./scripts/admin_script.js"></script>
</body>
</html>