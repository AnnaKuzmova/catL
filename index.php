<?php 

    include('config/database-connection.php');

    if(!isset($_SESSION)) {
        session_start();
    }

    //Query for first 5 cats to display
    $query_top_five_cats = "";
    if(isset($_SESSION['user_id'])) {
        $user_id = mysqli_real_escape_string($connection, $_SESSION["user_id"]);
        $query_top_five_cats = "SELECT * FROM cat WHERE user_id != $user_id LIMIT 5";

    } else {
        $query_top_five_cats = "SELECT * FROM cat LIMIT 5";
    }
   //Getting the results through the query
    $result = mysqli_query($connection, $query_top_five_cats);
   //Fetching the results
    $cats_to_display = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //Free the result
    mysqli_free_result($result);
    //Close the connection
    mysqli_close($connection);

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>catL</title>
        <?php 
            include("templates/links.php");
        ?>
        <link rel="stylesheet" href="styles/index.css">
    </head>
    <body>
        <?php 
            include("templates/header.php");
        ?>
       
       <main class="main-layout"> 
        <div class="center">
        <section class="intro-holder">
            <img src="images/photo-1596854273338-cbf078ec7071.jpeg" alt="cat picture" class="intro-cat-pic">
            <article class="intro-info-holder">
                <h3 class="heading">
                   Meet super-duper cool cats and say <q>No</q> to <span class="text-animate"></span>
                </h3>
                <p class="paragraph">
                &nbsp; Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum unde impedit libero explicabo consectetur laborum laboriosam! At quaerat nostrum deleniti officiis quae ad magnam odio aperiam? Eos facilis harum amet.
                </p>
                <p class="paragraph">
                &nbsp;  Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum unde impedit libero explicabo consectetur laborum laboriosam! At quaerat nostrum deleniti officiis quae ad magnam odio aperiam? Eos facilis harum amet.
                </p>
                <button class="button-check-out">
                    Read blog
                </button>
            </article>
        </section>
        <section>
            <h2 class="heading">See our babes:</h2>
            <div class="cat-display-holder">
        <?php foreach($cats_to_display as $cat) : ?>
            <article class="cat-info-holder">
            <img class="cat-picture" src="<?php echo htmlspecialchars($cat["cat_image"]) ?>" alt="cat picture user">
            <h3 class="cat-name"><?php echo htmlspecialchars($cat["name"]) . ',' . htmlspecialchars($cat["age"]) ?></h3>    
            <a href="details.php?cat-id=<?php echo htmlspecialchars($cat["id"]) ?>" class="see-more-button">details</a>
            <img src="images/cat-ping.png" alt="cat" class="cat-ping">
        </article>
        <?php endforeach; ?>
     
        </div>
        </section>
        </div>
       </main>
    
        <?php 
            include("templates/footer.php");
        ?>

        
        <script src="js/index.js"></script>
    </body>
</html>