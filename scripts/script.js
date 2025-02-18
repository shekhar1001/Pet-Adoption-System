let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () => {
  userBox.classList.toggle('active');
  navbar.classList.remove('active');
};

let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () => {
  navbar.classList.toggle('active');
  userBox.classList.remove('active');
};

window.onscroll = () =>{
  userBox.classList.remove('active');
  navbar.classList.remove('active');

  if(window.scrollY > 60){
    document.querySelector('.header .header-2').classList.add('active');
  }else{
    document.querySelector('.header .header-2').classList.remove('active');
  }
}




// Binary Search Implementation

// function startBinarySearch() {
//   var searchAge = parseInt(document.getElementById("searchAge").value);

//   // Clear previous visualization
//   arrayDiv.innerHTML = "";
//   resultDiv.textContent = "";

//   // Fetch animal ages from the database using AJAX
//   fetchAnimalAges(searchAge);
// }

// function fetchAnimalAges(target) {
//   // Send an AJAX request to fetch animal ages
//   var xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function () {
//       if (xhr.readyState === 4 && xhr.status === 200) {
//           var response = JSON.parse(xhr.responseText);

//           // Extract the ages from the response
//           var animalAges = response.map(function (animal) {
//               return animal.age;
//           });

//           // Sort the ages for binary search (assuming they are sorted in the database)
//           animalAges.sort(function (a, b) {
//               return a - b;
//           });

//           // Start the binary search visualization
//           visualizeBinarySearch(animalAges, target);
//       }
//   };

//   // Replace 'your_php_script.php' with the actual PHP script that fetches animal data
//   xhr.open("GET", "binarysearch.php", true);
//   xhr.send();
// }



// Rest of your script...



