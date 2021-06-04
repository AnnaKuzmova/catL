<?php
    include("config/database-connection.php");
    include("validations.php");
    $sign_in_error_message = '';
    if(isset($_POST['log-in-button'])) {
        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);

            $user_sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
            $user_result = mysqli_query($connection, $user_sql);
            $user = mysqli_fetch_assoc($user_result);
            mysqli_free_result($user_result);
            mysqli_close($connection);


            if($user) {
                session_start();

                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php");
            } else {
                $sign_in_error_message = "Invalid user. Please log in again.";
            }
            
        } else {
            $sign_in_error_message = "Please fill in all details.";
        }
    }

    $registerErrorMessage = ["email" => '', "password" => '', "name" => ''];
    if(isset($_POST['register-button'])) {

        if(empty($_POST['reg-email'])) {
            $registerErrorMessage['email'] = "Email address is not set.";
        }else {
            $email = mysqli_real_escape_string($connection, $_POST['reg-email']);
            $registerErrorMessage["email"] = check_email($email);
        }

        if(empty($_POST['reg-name'])) {
            $registerErrorMessage["name"] = "Name is not set.";
        } else {
            $name = mysqli_real_escape_string($connection, $_POST['reg-name']);
           $registerErrorMessage["name"] = check_name($name);
        }

        if(empty($_POST['reg-password'])) {
            $registerErrorMessage["password"] = "Password is not set.";
        } else {
            $password = mysqli_real_escape_string($connection, $_POST['reg-password']);
            $registerErrorMessage["password"] = check_password($password);
        }

        if(!array_filter($registerErrorMessage)) {
            $register_email_value = mysqli_real_escape_string($connection, $_POST["reg-email"]);
            $register_name_value = mysqli_real_escape_string($connection, $_POST["reg-name"]);
            $register_password_value = mysqli_real_escape_string($connection, $_POST["reg-password"]);

            $query = "INSERT INTO user(name , email , password) VALUES('$register_name_value' , '$register_email_value' , '$register_password_value')";

             if(mysqli_query($connection, $query)) {
                 $qrl = "SELECT id FROM user WHERE password = '$register_password_value'";
                 $reg_result = mysqli_query($connection, $qrl);
                 if($reg_result) {
                    if(!isset($_SESSION)) {
                        session_start();
                    }
                 $registered_user = mysqli_fetch_assoc($reg_result);
                 $_SESSION["user_id"] = $registered_user['id'];
                 header("Location: index.php");
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
        <title>CatL - Sign In</title>
        <?php include("templates/links.php"); ?>
        <link rel="stylesheet" href="styles/authentication.css">
    </head>
    <body>
        <?php include("templates/header.php"); ?>
        <main class="authentication-main-holder"> 
            <div class="center">
            <section class="auth-form-holder">
                <article class="sign-in-form">
                    <form class="sign-in" action="login.php" method="POST">
                        <h4>Sign In</h4>
                        <h3>
                            <label for="email">Email:</label>
                        </h3>
                        <input type="email" name="email" id="email" placeholder="youremailname@address.com">
                        <h3>
                            <label for="password">Password:</label>
                        </h3>
                        <input type="text" name="password" placeholder="8 digits (at least 1 uppercase letter)">
                        <p class="error-message"><?php echo $sign_in_error_message; ?></p>
                        <input type="submit" name="log-in-button" value="Submit">
                        <p class="go-to-register">
                        Dont have an account? <span class="reg">Register</span>
                    </p>
                    </form>
                </article>
                <article class="register-form">
                    <form class="register" action="login.php" method="POST">
                        <h4>Register</h4>
                        <h3>
                            <label for="reg-name">Name:</label>
                            <span><?php echo $registerErrorMessage["name"]?></span>
                        </h3>
                        <input type="text" name="reg-name" placeholder="example: John Smith">
                        <h3>
                            <label for="reg-email">Email:</label>
                            <span><?php echo $registerErrorMessage["email"]?></span>
                        </h3>
                        <input type="email" name="reg-email" placeholder="youremailname@address.com">
                        <h3>
                            <label for="reg-password">Password:</label>
                            <span><?php echo $registerErrorMessage["password"]?></span>
                        </h3>
                        <input type="text" name="reg-password" placeholder="8 digits (at least 1 uppercase letter)">
                        <input type="submit" name="register-button" value="Submit">
                        <p class="go-to-sign-in">
                        Already have an account? <span class="sign">Sign in</span>
                    </p>
                    </form>
                </article>
                <article class="logo-layout">
                    <h2 class="logo">
                        <img src="images/love.png" alt="logo">
                        catL
                    </h2>
                    <p>Discover <b>millions</b> of cat-friends.</p>
                    <p>Share and create great memories with out <b>cat-friendly</b> comunity.</p>
                </article>
            </section>
            </div>
        </main>
        <?php include("templates/footer.php"); ?>
        <script src="js/auth.js"></script>
    </body>
</html>