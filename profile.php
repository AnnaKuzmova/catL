<?php 
    include("config/database-connection.php");
    include("validations.php");

    if(!isset($_SESSION)) {
        session_start();
    }

    $img_dir = "uploads";
    $user_info = ["name" => "", "email" => "", "address" => "", "birthday" => ""];
    $user_cats = [];
    if(isset($_SESSION["user_id"]) && $_SESSION['user_id'] == $_GET['user']) {
        $user_id = $_SESSION["user_id"];
        //Code for deleting a cat
        if(isset($_POST["delete-button"])) {
            if(!empty($_POST["cat-delete-id"])) {
                $cat_id = mysqli_real_escape_string($connection, $_POST["cat-delete-id"]);
                $sql_delete_cat = "DELETE FROM cat WHERE id = $cat_id";
                $deleted_cat_result = mysqli_query($connection, $sql_delete_cat);

                if($deleted_cat_result) {
                    unset($_POST["cat-delete_id"]);
                    unset($_POST["delete-button"]);
                }
            }
        }

      //Code for editing/updating user's info  
        $edit_error_messages = ["name" => "", "email" => "", "address" => "", "birthday" => "","image" => ""];
        if(isset($_POST["edit-button"])) {
       
            if(!empty($_POST["user-name"])) {
            $name =  mysqli_real_escape_string($connection, $_POST["user-name"]);
            $edit_error_messages["name"] = check_name($name);
            } else {
            $edit_error_messages["name"] = "Name is not set.";
            }

            if(!empty($_POST["user-email"])) {
            $email = mysqli_real_escape_string($connection, $_POST["user-email"]);
            $edit_error_messages["email"] = check_email($email);
            } else {
            $edit_error_messages["email"] = "Email is not set.";
            }

            if(!empty($_POST["user-address"])) {
            $address = $_POST["user-address"];
            if(!preg_match('/^[a-zA-Z\s]+$/' , $address)) {
                $edit_error_messages["address"] = "Incorect address format.";
            } 
             } else {
            $edit_error_messages["messages"] = "Address is not set";
            }

            if(empty($_POST["user-birthday"])) {
                $edit_error_messages["birthday"] = "Birthday is not set.";
            } else {
                $birthday = mysqli_real_escape_string($connection,$_POST["user-birthday"]);
                $edit_error_messages["birthday"] = check_birthday($birthday);
            }

            if($_FILES["user-image"]["error"] == 0) {
            $image_name = $_FILES["user-image"]["name"];
            $edit_error_messages["image"] = check_image("user-image");
          }

        if(!array_filter($edit_error_messages)) {
            $sql = "";
            $edited_name = mysqli_real_escape_string($connection, $_POST["user-name"]);
            $edited_email = mysqli_real_escape_string($connection, $_POST["user-email"]);
            $edited_address = mysqli_real_escape_string($connection, $_POST["user-address"]);
            $edited_birthday = mysqli_real_escape_string($connection, $_POST["user-birthday"]);
            $edited_user = mysqli_real_escape_string($connection, $_POST["user-edit-id"]);
            $image = $_FILES["user-image"]["name"];

            if($_FILES["user-image"]["error"] == 4) {
                $sql = "UPDATE user SET name = '$edited_name', email = '$edited_email', address = '$edited_address', birthday = '$edited_birthday' WHERE id = $edited_user";
            } else {
                $sql = "UPDATE user SET name = '$edited_name', email = '$edited_email', address = '$edited_address', birthday = '$edited_birthday', user_image = '$img_dir/$image' WHERE id = $edited_user";
            }
           
            $result = mysqli_query($connection, $sql);
            move_uploaded_file($_FILES["user-image"]["tmp_name"], "$img_dir/$image");
            header("Location: profile.php?user=$user_id");
        }
    }

    $image_error_message = "";
    if(isset($_POST["upload-image-button"])) {
        $gallery_image_name = $_FILES["user-image-upload"]["name"];
        $image_error_message = check_image("user-image-upload");

        if(empty($image_error_message)) {
            $query = "INSERT INTO image(image, user_id) VALUES('$img_dir/$gallery_image_name', $user_id)";
            $result = mysqli_query($connection,$query);
            move_uploaded_file($_FILES["user-image-upload"]["tmp_name"],"$img_dir/$gallery_image_name");
            header("Location: profile.php?user=$user_id");
        }
    }

    $cat_error_messages = ["name" => "", "description" => "", "age" => "" , "image" => "", "cat_id" => ""];
     if(isset($_POST["edit-cat"])) {
         if(!empty($_POST["cat-edit-name"])) {
             $cat_name = mysqli_real_escape_string($connection, $_POST["cat-edit-name"]);
            $cat_error_messages["name"] = check_name($cat_name);
         } else {
             $cat_error_messages["name"] = "Cat name field is empty.";
         }

         if(!empty($_POST["cat-edit-description"])) {
            $cat_description = mysqli_real_escape_string($connection, $_POST["cat-edit-description"]);
            $cat_error_messages["description"] = check_description($cat_description);
         }else {
             $cat_error_messages["description"] = "Description field is empty.";
         }

         if(!empty($_POST["cat-edit-age"])) {
            $cat_age = mysqli_real_escape_string($connection, $_POST["cat-edit-age"]);
            $cat_error_messages["age"] = check_cat_age($cat_age);
         } else {
             $cat_error_messages["age"] = "Age field is empty";
         }

        if($_FILES["cat-edit-image"]["error"] == 0) {
            $cat_error_messages["image"] = check_image("cat-edit-image");
        }

        if(!array_filter($cat_error_messages)) {
            $sql = "";
            $cat_id = mysqli_real_escape_string($connection, $_POST["cat-edit-id"]);
            $cat_name = mysqli_real_escape_string($connection, $_POST["cat-edit-name"]);
            $cat_desc = mysqli_real_escape_string($connection, $_POST["cat-edit-description"]);
            $cat_age = mysqli_real_escape_string($connection, $_POST["cat-edit-age"]);
            $image = $_FILES["cat-edit-image"]["name"];

            if($_FILES["cat-edit-image"]["error"] == 4) {
                $sql = "UPDATE cat SET name = '$cat_name', description = '$cat_desc', age = $cat_age WHERE id = $cat_id";
            } else {
                $sql = "UPDATE cat SET name = '$cat_name', description = '$cat_desc', age = $cat_age, cat_image = '$img_dir/$image' WHERE id = $cat_id";
            }
           
            $result = mysqli_query($connection, $sql);
            move_uploaded_file($_FILES["cat-edit-image"]["tmp_name"], "$img_dir/$image");
            header("Location: profile.php?user=$user_id");
        } else {
            $cat_error_messages["cat_id"] = $_POST["cat-edit-id"];
        }


     }


        //Get data for the logged user 
        $sql = "SELECT name, email, address, birthday, user_image FROM user WHERE id = $user_id";
        $result = mysqli_query($connection, $sql);
        $user_info = mysqli_fetch_assoc($result);

        //Get all cat's data 
        $sql_user_cat = "SELECT * FROM cat WHERE user_id = $user_id";
        $cat_result = mysqli_query($connection, $sql_user_cat);
        $cats = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

        //Get all images for the user
        $sql_for_images = "SELECT * FROM image WHERE user_id = $user_id";
        $image_result = mysqli_query($connection,$sql_for_images);
        $user_images = mysqli_fetch_all($image_result, MYSQLI_ASSOC);
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <?php include("templates/links.php"); ?>
    <link rel="stylesheet" href="styles/profile.css">
</head>
<body>
    <?php include("templates/header.php"); ?>
    <main>
    <?php if(isset($_SESSION["user_id"]) && $_SESSION['user_id'] == $_GET['user']): ?>
        <div class="center">
            <form class="user-information-holder" action="profile.php?user=<?php echo htmlspecialchars($user_id); ?>" method="POST" enctype="multipart/form-data">
                <div class="image">
                    <img src="<?php echo $user_info["user_image"] ?>" alt="profile" class="display-user-image">
                    <div class="upload-image">
                        <input type="file" name="user-image" class="user-image">
                        <span><?php echo htmlspecialchars($edit_error_messages["image"]) ?></span>
                    </div>
                </div>
                <div class="profile-form" >
                <h2>Your information: </h2>
                <span class="error"><?php echo htmlspecialchars($edit_error_messages["image"]); ?></span>
                    <label for="name">
                       <span>Name:</span>
                        <input  type="text" name="user-name" value="<?php echo htmlspecialchars($user_info["name"]); ?>" >
                        <span><?php echo htmlspecialchars($edit_error_messages["name"]) ?></span>
                    </label>
                    <label for="email">
                        <span>Email:</span>
                        <input type="text" name="user-email" value="<?php echo htmlspecialchars($user_info["email"]); ?>" >
                        <span><?php echo htmlspecialchars($edit_error_messages["email"]) ?></span>
                    </label>
                    <label for="adress">
                        <span>Adress:</span>
                        <input type="text" name="user-address" value="<?php echo htmlspecialchars($user_info["address"]); ?>" >
                        <span><?php echo htmlspecialchars($edit_error_messages["address"]) ?></span>
                    </label>
                    <label for="bday">
                        <span>BDay:</span>
                        <input type="text" name="user-birthday" value="<?php echo htmlspecialchars($user_info["birthday"]); ?>">
                        <span><?php echo htmlspecialchars($edit_error_messages["birthday"]) ?></span>
                    </label>
                    <input type="hidden" name="user-edit-id" value="<?php echo $_SESSION["user_id"]; ?>">
                    <a class="edit-button">Edit</a>
                    <a class="cancel-button">Cancel</a>
                    <input class="submit-data" type="hidden" name="edit-button" value="Save">
                </div>
            </form>
            <section class="user-cat-holder">
                <h2 class="user-cat-heading">
                    <span class="active">Your cats</span> / <span>Gallery</span> <a href="add-cat.php?user=<?php echo htmlspecialchars($user_id); ?>" class="button add-cat">Add cat</a> <a class="button add-picture">Add picture</a>
                </h2>
                <section class="cats-holder">
                <?php $n = 0; ?>
                    <?php foreach($cats as $cat): ?>

                    <article class="cat-box">
                    <form action="profile.php?user=<?php echo htmlspecialchars($_SESSION["user_id"]); ?>" method="POST" class="cat-delete">
                       <input type="hidden" name="cat-delete-id" value="<?php echo htmlspecialchars($cat["id"]); ?>">
                           <button type="submit" name="delete-button" value="delete">
                            Remove
                           </button>
                       </form>
                       <div class="image-holder">
                        <img class="cat-image-holder" src="<?php echo htmlspecialchars($cat["cat_image"]) ?>" alt="catsy" count = "<?php echo $n; ?>">
                        <button class="cat-edit-button" count="<?php echo $n; ?>">Edit</button>
                        </div>
                        <form style="flex-grow:1;" class="cat-data" action="profile.php?user=<?php echo htmlspecialchars($user_id); ?>" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="cat-edit-id" value="<?php echo htmlspecialchars($cat["id"]) ?>">
                            <h3>Name:</h3>
                            <input type="text" name="cat-edit-name" value="<?php echo htmlspecialchars($cat["name"]); ?>" disabled class="cat-edit-input" count = "<?php echo $n; ?>">
                            <h3>Description:</h3>
                            <textarea id="textare"  disabled name="cat-edit-description" class="cat-edit-input" count = "<?php echo $n; ?>"> <?php echo htmlspecialchars($cat["description"]); ?></textarea>
                            <h3>Age:</h3>
                            <input type="text" name="cat-edit-age" value="<?php echo htmlspecialchars($cat["age"]); ?>" disabled class="cat-edit-input" count = "<?php echo $n; ?>">
                            <input class="cat-edit-upload-photo" type="file" name="cat-edit-image" count = "<?php echo $n; ?>">
                            <br>
                            <input type="submit" name="edit-cat" value="Save" class="save-cat"  count = "<?php echo $n; ?>">
                            <a class="cancel-cat-edit"  count = "<?php echo $n; ?>">Cancel</a>
                        </form>
                        <?php if($cat_error_messages["cat_id"] == $cat["id"]): ?>
                            <?php foreach($cat_error_messages as $err): ?>
                                <p><?php echo htmlspecialchars($err) ?></p>
                            <?php endforeach; ?>   
                        <?php endif; ?>     
                    </article>
                    <?php $n++; ?>
                <?php endforeach; ?>
                </section>
                <section class="gallery-holder">
                        <div class="gallery-flex">
                        <?php if(!empty($user_images)): ?>
                        <?php foreach($user_images as $image): ?>
                            <img src="<?php echo htmlspecialchars($image["image"]); ?>" alt="image" class="gallery-image">
                        <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-images">
                                <img src="images/no-photos.png" alt="no imgages">
                                <h2>No images uploaded yet.</h2>
                            </div>
                        <?php endif; ?>
                        </div>
                </section>
        </div>
        
<?php else: ?>
    <div class="center">
        <h2>Illegal action! Please return to home page.</h2>
    </div>

    <?php endif; ?>

     </main>
    <?php include("templates/footer.php"); ?>

    <section class="add-picture-modal">
                        <article class="modal">
                        <img src="images/photo.png" alt="" class="modal-img">
                            <form action="profile.php?user=<?php echo htmlspecialchars($_SESSION["user_id"]); ?>" method="POST" enctype="multipart/form-data">
                                <input type="file" name="user-image-upload" class="image-input">
                                <input class="upload-image-button" type="submit" name="upload-image-button" value="Submit">
                                <a class="cancel">Cancel</a>
                                <span class="error"><?php echo htmlspecialchars($image_error_message) ?></span>
                            </form>
                        </article>
        </section>
        <section class="display-image-modal">
              <div class="img-display">
                <img src="" alt="" class="user-img-tag">
                <section class="controls">
                <i class="fas fa-angle-left" id="previous-cat"></i>
                <i class="fas fa-times" id="close-user-image-modal"></i>
                <i class="fas fa-angle-right" id="next-cat"></i>
                </section>
              </div>      
        </section>


    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/plugins/CSSPlugin.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenLite.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TimelineLite.min.js"></script>
    <script src="js/profile.js"></script>
</body>
</html>