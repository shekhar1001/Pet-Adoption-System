<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo">Admin <span>Panel</span></a>

        <p id="greeting">Welcome <span><?php echo $_SESSION['admin_email']; ?></span></p>

        <nav class="navbar">
            <a href="admin_page.php" style="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_page.php') echo 'color: #8e44ad;'; ?>">Home</a>
            <a href="admin_products.php" style="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_products.php') echo 'color: #8e44ad;'; ?>">Animal</a>
            <a href="admin_users.php" style="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_users.php') echo 'color: #8e44ad;'; ?>">Users</a>
            <a href="admin_show_adoption_details.php" style="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_show_adoption_details.php') echo 'color: #8e44ad;'; ?>">Adoptions</a>
            <a href="admin_contacts.php" style="<?php if (basename($_SERVER['PHP_SELF']) == 'admin_contacts.php') echo 'color: #8e44ad;'; ?>">Messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>Username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>Email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Logout</a>
        </div>

    </div>
</header>