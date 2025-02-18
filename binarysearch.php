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
    <h1 class="title">Age of animal available(Database)<h1>
    <section class="show-animals">
        <div class="box-container" >
        
        <div id="searchAge">
        <?php
                    // Quering to select distinct ages from the "animals" table
                    
                    // Initializing an empty array to store the distinct ages
$animalAges = array();

// Query to select distinct ages from the "animals" table
$query = "SELECT DISTINCT age FROM animals ORDER BY age ASC";
$result = mysqli_query($connect, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $age = $row['age'];
        $animalAges[] = $age; // Adding each distinct age to the array
    }

    // Converting the array of ages to a string in the desired format
    $ageString = "age={" . implode(', ', $animalAges) . "}";
    echo $ageString;
} else {
    echo "No ages found";
}


        ?>
        <div>
    <!-- Add more age options as needed -->
        </div>
    </section>
    <section class="show-animals">
        <div class="box-container">
    <?php
    
        $search = "SELECT DISTINCT age FROM animals ORDER BY age ASC";
        $search_result = mysqli_query($connect, $search);
    // Replace 'animals' with your actual table name and 'age' with the column name for age
    if ($search_result) {
        $animalAges = array();
        while ($row = mysqli_fetch_assoc($search_result)) {
            $animalAges[] = $row['age'];
        }
    
    } else {
        $animalAges = array();  // Return an empty array in case of an error
    }

    function binarySearch($animalAges, $searchAge) {
        $left = 0;
        $right = count($animalAges) - 1;
    
        while ($left <= $right) {
            $mid = $left + floor(($right - $left) / 2);
    
            if ($animalAges[$mid] == $searchAge) {
                return $mid; // Element found, return its index
            }
    
            if ($animalAges[$mid] < $searchAge) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }
    
        return -1; // Element not found
    }
    
    // Example: Search for a specific age
    $startAge = 1; // Start age
    $endAge = 14;  // End age
for ($searchAge = $startAge; $searchAge <= $endAge; $searchAge++) {
    // Perform binary search for the current searchAge
    $foundIndex = binarySearch($animalAges, $searchAge);

    if ($foundIndex !== -1) {
        $foundAge = $animalAges[$foundIndex];
        echo "Age $searchAge found at index $foundIndex in the sorted list. Found Age: $foundAge<br>";
    } else {
        echo "Age $searchAge not found in the sorted list.<br>";
    }
    }
    ?>
     </div>
    </section>
    <?php require_once './footer.php'; ?>

    <!-- ------- JS Link ------- -->
    <script src="./scripts/script.js"></script>

</body>
</html>