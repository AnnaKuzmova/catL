<?php 
    //include the connection
    include("config/database-connection.php");
    //check if user clicked on details button
    if(isset($_GET['cat-id'])) {
        //get the id from the request and put it into a variable
        $cat_id = mysqli_real_escape_string($connection, $_GET['cat-id']);
        //make the query for the requested cat
        $sql_for_cat = "SELECT * FROM cat WHERE id = $cat_id";
        //get the result 
        $result_cat = mysqli_query($connection, $sql_for_cat);
        //fetch the result 
        $cat = mysqli_fetch_assoc($result_cat);
        $user_id =  $cat['user_id'];

        //get the owner's name
        $sql_for_owner = "SELECT name FROM user WHERE id = $user_id";
        $result_for_owner = mysqli_query($connection, $sql_for_owner);
        $owner_name = mysqli_fetch_assoc($result_for_owner);

        //free the result and then close the connection 
        mysqli_free_result($result_cat);
        mysqli_close($connection);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Details - <?php echo $cat['name'];  ?> </title>
        <?php 
            include("templates/links.php");
        ?>
        <link rel="stylesheet" href="styles/details.css">
    </head>
    <body>
        <?php include("templates/header.php"); ?>
        <main class="details-main-container"> 
            <div class="center">
                <?php if($cat && $owner_name): ?>
                <section class="cat-details-holder">
                    <article class="cat-image">
                    <img src="<?php echo htmlspecialchars($cat["cat_image"]); ?>" alt="cat" class="cat-details-picture">
                    </article>
                    <article class="cat-info">
                        <h2 class="cat-info-name"><?php echo htmlspecialchars($cat['name']);?>
                            <img src="images/print.png" alt="catt" class="name-ping">
                        </h2>
                        <h4 class="cat-info-type">
                        Owner:
                            <p><?php echo htmlspecialchars($owner_name['name']); ?></p>
                        </h4>
                        <h4 class="cat-info-type">
                        Age:
                            <p><?php echo htmlspecialchars($cat['age']); ?></p>
                        </h4>
                        <h4 class="cat-info-type">
                        Description:
                            <p><?php echo htmlspecialchars($cat['description']); ?></p>
                        </h4>
                    </article>
                </section>
                <?php else: ?> 
                    <section class="cat-details-holder">
                        <p class="error-message">
                            Currently the cat you are looking for doesnt exists in out database. Try again next time!
                        </p>
                    </section>
                <?php endif; ?>    
            </div>
        </main>   
        <?php include("templates/footer.php"); ?>
    </body>
</html>