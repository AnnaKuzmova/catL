<?php 
    if(!isset($_SESSION)) {
        session_start();
    }

    include("config/database-connection.php");

    if(isset($_SESSION["user_id"]) && $_SESSION['user_id'] == $_GET['user']) {
        $user_id = mysqli_real_escape_string($connection,$_SESSION["user_id"]);
        $cat_error_messages = ["name" => "", "description" => "", "age" => ""];

        if(isset($_POST["add-cat-button"])) {
            if(!empty($_POST["cat-name"])) {
                $cat_name = mysqli_real_escape_string($connection, $_POST["cat-name"]);
                if(!preg_match('/[A-Z][\w]+/',$cat_name)) {
                    $cat_error_messages["name"] = "Cat's name must start with uppercase letter.";
                } 
            } else {
                $cat_error_messages["name"] = "Please set a name for cat.";
            }

            if(!empty($_POST["cat-description"])) {
                $description = mysqli_real_escape_string($connection, $_POST["cat-description"]);
                if(strlen($description) >= 255 || !preg_match('/[A-Z][\w]+/', $description)) {
                    $cat_error_messages["description"] = "Incorect description format.";
                }
            } else {
                $cat_error_messages["description"] = "Description is unset.";
            }

            if(!empty($_POST["cat-age"])) {
                $age = mysqli_real_escape_string($connection, $_POST["cat-age"]);
                if(!is_numeric($age)) {
                    $cat_error_messages["age"] = "Cat's age is not in the correct format";
                }
            }else {
                $cat_error_messages["age"] = "Cat's age is unset.";
            }


            if(!array_filter($cat_error_messages)) {
                $cat_name = mysqli_real_escape_string($connection, $_POST["cat-name"]);
                $cat_description = mysqli_real_escape_string($connection, $_POST["cat-description"]);
                $cat_age = (int)mysqli_real_escape_string($connection, $_POST["cat-age"]);

                $sql = "INSERT INTO cat(name,description,age, user_id) VALUES('$cat_name','$cat_description', $cat_age, $user_id)";

                if(mysqli_query($connection,$sql)) {
                    header("Location: profile.php?user=$user_id");
                }
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catL- Add Cat</title>
    <?php include("templates/links.php"); ?>
    <link rel="stylesheet" href="styles/add-cat.css">
</head>
<body>
    <?php include("templates/header.php"); ?>

    <main> 
        <?php if(isset($_SESSION["user_id"]) && $_SESSION['user_id'] == $_GET['user']): ?>
           <div class="center">
           <section class="add-cat-form-holder">
                <form class="cat-form" action="add-cat.php?user=<?php echo htmlspecialchars($user_id) ?>" method="POST">
                   <h2 class="heading">Add cat</h2>
                    <h3>Name:</h3>
                    <span><?php echo htmlspecialchars($cat_error_messages["name"]) ?></span>
                    <input type="text" name="cat-name" placeholder="Your cat's name..">
                    <h3>Description:</h3>
                    <span><?php echo htmlspecialchars($cat_error_messages["description"]) ?></span>
                    <textarea name="cat-description" id="desc" placeholder="Your cat's description. Example: cute, nice, fluffy.."></textarea>
                    <h3>Age:</h3>
                    <span><?php echo htmlspecialchars($cat_error_messages["age"]) ?></span>
                    <input type="text" name="cat-age" placeholder="Your cat's age">
                    <input type="submit" name="add-cat-button" value="Submit">
                </form>
            </section>
           </div>
            <?php else: ?>
                <h2>Please sign in to be able to see more content. Dont have an account? <a href="login.php">Register.</a></h2>
                <?php endif; ?>

               
    </main>

    <?php include("templates/footer.php"); ?>
    <svg id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150"><path d="M 0,400 C 0,400 0,100 0,100 C 72.06698564593302,85.52153110047847 144.13397129186603,71.04306220095694 247,78 C 349.86602870813397,84.95693779904306 483.53110047846894,113.34928229665073 583,118 C 682.4688995215311,122.65071770334927 747.7416267942582,103.5598086124402 840,98 C 932.2583732057418,92.4401913875598 1051.5023923444976,100.41148325358853 1156,103 C 1260.4976076555024,105.58851674641147 1350.248803827751,102.79425837320574 1440,100 C 1440,100 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill="#ff008066" class="transition-all duration-300 ease-in-out delay-150"></path><path d="M 0,400 C 0,400 0,200 0,200 C 98.23923444976077,218.19138755980862 196.47846889952154,236.38277511961724 279,229 C 361.52153110047846,221.61722488038276 428.32535885167465,188.6602870813397 538,183 C 647.6746411483253,177.3397129186603 800.2200956937801,198.97607655502392 897,203 C 993.7799043062199,207.02392344497608 1034.7942583732056,193.4354066985646 1116,190 C 1197.2057416267944,186.5645933014354 1318.6028708133972,193.28229665071768 1440,200 C 1440,200 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill="#ff008088" class="transition-all duration-300 ease-in-out delay-150"></path><path d="M 0,400 C 0,400 0,300 0,300 C 94.00956937799043,287.7511961722488 188.01913875598086,275.50239234449765 279,274 C 369.98086124401914,272.49760765550235 457.9330143540669,281.7416267942583 567,288 C 676.0669856459331,294.2583732057417 806.2488038277511,297.5311004784689 901,295 C 995.7511961722489,292.4688995215311 1055.0717703349283,284.13397129186603 1139,284 C 1222.9282296650717,283.86602870813397 1331.4641148325359,291.933014354067 1440,300 C 1440,300 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill="#ff0080ff" class="transition-all duration-300 ease-in-out delay-150"></path></svg>
</body>
</html>