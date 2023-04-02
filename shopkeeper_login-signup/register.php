<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $phone = $c_name = $password = $confirm_password = "";
$phone_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate phone
    if(empty(trim($_POST["sh_phone"]))){
        $phone_err = "Please enter a phone.";
    } elseif(!preg_match('/^[0-9+]+$/', trim($_POST["sh_phone"]))){
        $phone_err = "Phone can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM shopowners WHERE sh_phone = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_phone);
            
            // Set parameters
            $param_phone = trim($_POST["sh_phone"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $phone_err = "This phone is already taken.";
                } else{
                    $phone = trim($_POST["phone"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate name
if(empty(trim($_POST["name"]))){
    $name_err = "Please enter your name.";
} else{
    $name = trim($_POST["name"]);
}

// Validate company name
if(empty(trim($_POST["c_name"]))){
    $c_name_err = "Please enter your company name.";
} else{
    $c_name = trim($_POST["c_name"]);
}
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($phone_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO shopowners (name, sh_phone, c_name, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_phone, $param_c_name, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_phone = $phone;
            $param_c_name = $c_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>
   <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="form-container">
    <form form action="" method="post">
        <h3>Sign Up</h3>
        
            <div class="form-group">
                <input type="text" name="name" required placeholder="Enter your name" class="form-control" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="sh_phone" required placeholder="Enter your Phone Number" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group">
                <input type="text" name="c_name" required placeholder="Enter your Company Name" class="form-control" value="<?php echo $c_name; ?>">
            </div>   
            <div class="form-group">
                <input type="password" name="password" required placeholder="Enter Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" required placeholder="Confirm Password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            </div>
            <p>Already have an account? <a href="reset-password.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>

