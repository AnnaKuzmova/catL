<?php 

    include("config/database-connection.php");
    include("validations.php");

    if(!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION["user_id"])) {
        header("Location: index.php");
    }

    if(isset($_POST["delete-button"])) {
        $table = mysqli_real_escape_string($connection, $_POST["type"]);
        $id = mysqli_real_escape_string($connection, $_POST["id"]);

        $query = "DELETE FROM $table WHERE id = $id";
        $result = mysqli_query($connection,$query);
    }

    $sql_for_cats = "SELECT * FROM cat";
    $cat_result = mysqli_query($connection, $sql_for_cats);
    $cats = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

 
    $sql_for_users = "SELECT * FROM user";
    $user_result = mysqli_query($connection, $sql_for_users);
    $users = mysqli_fetch_all($user_result, MYSQLI_ASSOC);
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controls</title>
    <?php 
        include("templates/links.php");
    ?>
    <link rel="stylesheet" href="styles/controls.css">
</head>
<body>
    <?php include("templates/header.php"); ?>
       <main> 
        <div class="center">
            <div class="content-holder">
                <section class="cat-holder">
                    <h3>Cats</h3>
                    <?php foreach($cats as $cat): ?>
                    <article class="box">
                        <img src="<?php echo htmlspecialchars($cat["cat_image"]); ?>" alt="<?php echo htmlspecialchars($cat["name"]); ?>">
                        <div class="information-holder">
                            <h2><?php echo htmlspecialchars($cat["name"]); ?></h2>
                            <p><?php echo htmlspecialchars($cat["description"]); ?></p>
                            <button cat="<?php echo htmlspecialchars($cat["id"]); ?>" class="delete-cat-button">delete</button>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </section>
                <section class="user-holder">
                <h3>Users</h3>
                <?php foreach($users as $user): ?>
                    <?php if($user["id"] != $_SESSION["user_id"]): ?>
                    <article class="box">
                        <img src="<?php echo htmlspecialchars($user["user_image"]); ?>" alt="<?php echo htmlspecialchars($user["name"]); ?>">
                        <div class="information-holder">
                            <h2><?php echo htmlspecialchars($user["name"]); ?></h2>
                            <p>Email: <?php echo htmlspecialchars($user["email"]); ?> <br> Address: <?php echo htmlspecialchars($user["address"]); ?> <br> Birthday:<?php echo htmlspecialchars($user["birthday"]); ?>  </p>
                            <button user="<?php echo htmlspecialchars($user["id"]); ?>" id="delete-user-button">delete</button>
                        </div>
                    </article>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
       </main>
    <?php include("templates/footer.php"); ?>
    <section class="confirmation-modal">
        <article class="confirmation-box">
            <img src="images/alert.png" alt="" class="alert-signal">
            <h4 class="modal-heading"></h4>
            <form action="controls.php" method="post" id="form">
                <input type="hidden" name="type" class="type">
                <input type="hidden" name="id" class="current">
                <button type="submit" name="delete-button" value="yes" class="delete btn">Yes</button>
                <a class="decline btn">No</a>
            </form>
        </article>
    </section>


    <script src="js/controls.js"></script>
</body>
</html>