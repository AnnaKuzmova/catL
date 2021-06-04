<?php

    include("config/database-connection.php");

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION["user_id"])) {

    }

    $sql = "";
    if(!isset($_POST["filter-cat"])) {
        $sql = "SELECT * FROM cat";
    } else {
        switch($_POST["filter-val"]) {
            case "age-less-than-5" :
                $sql = "SELECT * FROM cat WHERE age < 5";
                break;
            case "age-bogger-than-5" :
                $sql = "SELECT * FROM cat WHERE age > 5";
                break;
            case "name-asc" :
                $sql = "SELECT * FROM cat ORDER BY name ASC";
                break;
            case "name-desc" : 
                $sql = "SELECT * FROM cat ORDER BY name DESC";
                break;     
        }
    }


    $result = mysqli_query($connection, $sql);
    $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cats</title>
    <?php include("templates/links.php"); ?>
    <link rel="stylesheet" href="styles/cats.css">
</head>
<body>
    <?php include("templates/header.php"); ?> 
    <?php if(isset($_SESSION["user_id"])): ?>
        <main>
            <form class="filter" action="cats.php" method="POST">
                <h3>Filter by:</h3>
                    <select name="filter-val">
                     <optgroup>
                         <option value="age-less-than-5">Age less than 5</option>
                         <option value="age-bogger-than-5">Age bigger than 5</option>
                     </optgroup>
                     <optgroup>
                         <option value="name-asc">Name ascending</option>
                         <option value="name-desc">Name descending</option>
                     </optgroup>
                    </select>
                    <input type="submit" name="filter-cat" value="Filter">
            </form>
            <h2>Cats:</h2>
            <section class="cat-holder">
                <?php foreach($cats as $cat): ?>
                    <?php
                        $usr = "SELECT * FROM user WHERE id = {$cat['user_id']}";
                        $res = mysqli_query($connection, $usr);
                        $user = mysqli_fetch_assoc($res);    
                    ?>
                    <article class="cat">
                    <img src="<?php echo htmlspecialchars($cat["cat_image"]); ?>" alt="">
                    <div class="information">
                        <h3><?php echo htmlspecialchars($cat["name"]); ?></h3>
                        <p><b>Age:</b> <?php echo htmlspecialchars($cat["age"]); ?></p>
                        <p><?php echo htmlspecialchars($cat["description"]); ?></p>
                        <p><b>Owner:</b>  <?php echo htmlspecialchars($user["name"]); ?> - <?php echo htmlspecialchars($user["email"]); ?></p>
                    </div>
                </article>
                <?php endforeach; ?>    
               
            </section>
        </main>
    <?php else: ?>
        <section class="holder">
            <img src="images/alert.png" alt="oops">
            <h2>Oops! Looks like you havent logged in or not a user</h2>
            <a href="login.php">Log in</a>
        </section>
    <?php endif; ?>
    <?php include("templates/footer.php"); ?> 
</body>
</html>