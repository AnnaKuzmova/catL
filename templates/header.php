<?php 
    include("config/database-connection.php");
    if(!isset($_SESSION)) {
        session_start();
    }

    $user = '';
    $name = '';
    if(isset($_SESSION['user_id'])) {
        $id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
        $sql = "SELECT * FROM user WHERE id = $id";
        $result = mysqli_query($connection, $sql);
        $user = mysqli_fetch_assoc($result);
    }
?>


<header class="main-header">
    <div class="center">
    <nav class="main-navigation">
        <h2 id="logo">
            <img src="images/love.png" alt="logo" class="header-logo">CatL
        </h2>
        <ul class="navigation-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="cats.php">Cats</a></li>
            <?php if(!empty($user["isAdmin"])): ?>
            <li><a href="controls.php">Controls</a></li>
            <?php endif; ?>
            <?php if(!empty($user)): ?>
            <li class="profile"><a href="profile.php?user=<?php echo $user["id"]; ?>" > <?php echo $user['name']; ?> (<?php if(!empty($user["isAdmin"])): ?> <?php echo "Admin" ?> <?php else: ?> <?php echo "Your profile"; ?> <?php endif; ?>)</a></li>
            <li class="logout"><a href="logout.php">Logout</a></li>
            <?php else: ?>
            <li><a href="login.php">Sign In</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</header>