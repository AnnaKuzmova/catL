<?php 

    //Function for name validation, returns error message if mistake found else empty string 
    function check_name($name) : string {
        if(!preg_match('/^[a-zA-Z\s]+$/',$name)) {
            return "Incorect name format.";
        } else {
            return "";
        }
    }

    //Group email validation in function to reuse it more efficiently
   function check_email($email) : string {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return "Email address is not valid.";
        } else {
            return "";
        }
   }

//Password function checker
   function check_password($password) : string {
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/' , $password)) {
        return "Password must be at leat 8 characters long(1 capital and 1 digit)";
        } else {
            return "";
        }
   }

   // Description function validations 
   function check_description($description) : string {
        if(strlen($description) >= 255 || !preg_match('/[A-Z][\w]+/', $description)) {
        return "Incorect description format.";
        } else {
            return "";
        }
   }

   //Cat age checker
   function check_cat_age($age) : string {
        if(!is_numeric($age)) {
        return "Cat's age is not in the correct format";
        } else {
            return "";
        }
   }

   function check_birthday($birthday) : string {
       $birthday = explode(" ", $birthday);
       if(count($birthday) == 2) {
            if(preg_match("/^(3[0-1]|[1-2][0-9]|[1-9])$/", $birthday[0]) && preg_match("/Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:tember)?|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?/", $birthday[1])) {
                return "";
            } else {
                return "Birthday is not in the correct format.";
            }
       } else {
           return "Birthday not in the correct format.";
       }
   }

   function check_image($img_name) : string {
    $image_name = $_FILES[$img_name]["name"];
    $error = $_FILES[$img_name]["error"];
    $image_extensions = explode(".", $image_name);
    $acceptable_extensions = array("jpg", "jpeg", "png", "pdf");
    if(count($image_extensions) == 2 && $error == 0) {
        if(!in_array(end($image_extensions), $acceptable_extensions)) {

            return  "Incorect image extension. Check your file format.";
        } else {
            return "";
        }
    }else {
        return  "Incorect image format";
    }
   }

?>