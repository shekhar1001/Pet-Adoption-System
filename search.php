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
    <title>Search</title>

    <!-- Font-Awesome-Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style-Link -->
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <?php require_once './header.php'; ?>
    <section>
        <h1 class="title">Search</h1>
        <form action="" method="post" enctype="multipart/form-data">
    <label for="breed">Animal Breed</label>
    <select class="box" name="breed" required>
        <?php
        $breedOptions = mysqli_query($connect, "SELECT DISTINCT breed FROM animals");
        while ($row = mysqli_fetch_assoc($breedOptions)) {
            echo '<option value="' . $row['breed'] . '">' . $row['breed'] . '</option>';
        }
        ?>
    </select>
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
            <input type="number" class="box" min="1" max="20" name="age" placeholder="Age..." required>
            <input type="submit" value="Filter" name="filter_animals" class="btn">
        </form>
    </section>
    <section class="show-animals">
        <div class="box-container">
        <?php
if (isset($_POST['filter_animals'])) {
    // Collect filter criteria from the form
    $filterCriteria = array();

    $breed = mysqli_real_escape_string($connect, $_POST['breed']);
    $gender = mysqli_real_escape_string($connect, $_POST['gender']);
    $size = mysqli_real_escape_string($connect, $_POST['size']);
    $vaccine = mysqli_real_escape_string($connect, $_POST['vaccine']);
    $age = mysqli_real_escape_string($connect, $_POST['age']);

    // Build the SQL query based on the provided criteria
    $query = "SELECT * FROM `animals` WHERE 1";


    if (!empty($breed)) {
        $filterCriteria[] = "`breed` LIKE '%$breed%'";
    }

    if (!empty($gender)) {
        $filterCriteria[] = "`gender` = '$gender'";
    }

    if (!empty($size)) {
        $filterCriteria[] = "`size` = '$size'";
    }

    if (!empty($vaccine)) {
        $filterCriteria[] = "`vaccine` = '$vaccine'";
    }

    if (!empty($age)) {
        $filterCriteria[] = "`age` = '$age'";
    }

    // Check if there are filter criteria
    if (!empty($filterCriteria)) {
        // Add the filter criteria to the query
        $query .= " AND " . implode(" AND ", $filterCriteria);
        
        // Execute the query
        $result = mysqli_query($connect, $query) or die('Query failed');

        // Display filtered animals
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<form action="" method="POST" class="box">
                <img src="uploaded_img/' . $row['image'] . '" alt="">
                <div class="data">Name: <span>' . $row['name'] . '</span></div>
                <div class="data">Age: <span>' . $row['age'] . '</span></div>
                <div class="data">Gender: <span>' . $row['gender'] . '</span></div>
                <div class="data">Size: <span>' . $row['size'] . '</span></div>
                <div class="data">Breed: <span>' . $row['breed'] . '</span></div>
                <div class="data">Vaccinated: <span>' . $row['vaccine'] . '</span></div>
                <div class="data">Address: <span>' . $row['address'] . '</span></div>
                <div class="data">Description: <span>' . $row['description'] . '</span></div>
                <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
            </form>';
            }
        } else {
            echo '<p class="empty">No animals match the filter criteria.</p>';
        }
    } else {
        // If there are no filter criteria, display a message
        echo '<p class="empty">Please enter at least one filter criterion.</p>';
    }
}
?>
        </div>
    </section>
    <form action="" method="post" enctype="multipart/form-data">
            <input type="text" class="box" min="1" max="20" name="search" placeholder="Search..." required value="<?php echo htmlspecialchars($searchTerm); ?>">
            <input type="submit" value="Breed" name="breed" class="btn">
            <input type="submit" value="Age" name="age" class="btn">
            <input type="submit" value="Gender" name="gender" class="btn">
            <input type="submit" value="Size" name="size" class="btn">
            <input type="submit" value="Vaccine" name="vaccine" class="btn">
            <input type="submit" value="Address" name="address" class="btn">
        </form>
        <section class="show-animals">
        <div class="box-container">
        <?php
        $searchTerm='';
if (isset($_POST['breed'])) {
    $filterCriteria = array();

    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'breed' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`breed` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
   
}
if (isset($_POST['age'])) {
    $filterCriteria = array();

    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'age' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`age` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
}
if (isset($_POST['gender'])) {
    $filterCriteria = array();

    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'gender' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`gender` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
    
}
if (isset($_POST['address'])) {
    $filterCriteria = array();

    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'address' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`address` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
}
if (isset($_POST['vaccine'])) {
    $filterCriteria = array();

    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'vaccine' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`vaccine` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
}
if (isset($_POST['size'])) {
    $filterCriteria = array();
    $searchTerm = mysqli_real_escape_string($connect, $_POST['search']); // Change 'size' to 'search'

    if (!empty($searchTerm)) {
        $filterCriteria[] = "`size` LIKE '%$searchTerm%'"; // Update this line to include other criteria as needed
    }
   
}
    if (!empty($filterCriteria)) {
        $query = "SELECT * FROM `animals` WHERE " . implode(" AND ", $filterCriteria);
        $result = mysqli_query($connect, $query) or die('Query failed');
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<form action="" method="POST" class="box">
                <img src="uploaded_img/' . $row['image'] . '" alt="">
                <div class="data">Name: <span>' . $row['name'] . '</span></div>
                <div class="data">Age: <span>' . $row['age'] . '</span></div>
                <div class="data">Gender: <span>' . $row['gender'] . '</span></div>
                <div class="data">Size: <span>' . $row['size'] . '</span></div>
                <div class="data">Breed: <span>' . $row['breed'] . '</span></div>
                <div class="data">Vaccinated: <span>' . $row['vaccine'] . '</span></div>
                <div class="data">Address: <span>' . $row['address'] . '</span></div>
                <div class="data">Description: <span>' . $row['description'] . '</span></div>
                <input type="submit" value="Take me home!" name="adopt_animal" class="btn">
            </form>';
            }
        } else {
            echo '<p class="empty">No animals match the search.</p>';
        }
    } else {
        echo '<p class="empty">Please enter a search term.</p>';
    }
?>
        </div>
    </section>
    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>

</body>
</html>