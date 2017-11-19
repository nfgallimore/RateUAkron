

    <?php

    // Include config file

    require_once 'config.php';

     

    // Define variables and initialize with empty values

    $Id = $password = $confirm_password = "";

    $Id_err = $password_err = $confirm_password_err = "";

     

    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){

     

        // Validate Id

        if(empty(trim($_POST["Id"]))){

            $Id_err = "Please enter a Id.";

        } else{

            // Prepare a select statement

            $sql = "SELECT id FROM Students WHERE Id = ?";

            

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "s", $param_Id);

                

                // Set parameters

                $param_Id = trim($_POST["Id"]);

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    /* store result */

                    mysqli_stmt_store_result($stmt);

                    

                    if(mysqli_stmt_num_rows($stmt) == 1){

                        $Id_err = "This Id is already taken.";

                    } else{

                        $Id = trim($_POST["Id"]);

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Validate password

        if(empty(trim($_POST['password']))){

            $password_err = "Please enter a password.";     

        } elseif(strlen(trim($_POST['password'])) < 6){

            $password_err = "Password must have atleast 6 characters.";

        } else{

            $password = trim($_POST['password']);

        }

        

        // Validate confirm password

        if(empty(trim($_POST["confirm_password"]))){

            $confirm_password_err = 'Please confirm password.';     

        } else{

            $confirm_password = trim($_POST['confirm_password']);

            if($password != $confirm_password){

                $confirm_password_err = 'Password did not match.';

            }

        }

        

        // Check input errors before inserting in database

        if(empty($Id_err) && empty($password_err) && empty($confirm_password_err)){

            

            // Prepare an insert statement

            $sql = "INSERT INTO Students (Id, Password) VALUES (?, ?)";

             

            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "ss", $param_Id, $param_password);

                

                // Set parameters

                $param_Id = $Id;

                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Redirect to login page

                    header("location: login.php");

                } else{

                    echo "Something went wrong. Please try again later.";

                }

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        }

        

        // Close connection

        mysqli_close($link);

    }

    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Sign Up</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif; }

            .wrapper{ width: 350px; padding: 20px; }

        </style>

    </head>

    <body>

        <div class="wrapper">

            <h2>Sign Up</h2>

            <p>Please fill this form to create an account.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($Id_err)) ? 'has-error' : ''; ?>">

                    <label>Id:<sup>*</sup></label>

                    <input type="text" name="Id"class="form-control" value="<?php echo $Id; ?>">

                    <span class="help-block"><?php echo $Id_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                    <label>Password:<sup>*</sup></label>

                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                    <span class="help-block"><?php echo $password_err; ?></span>

                </div>

                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                    <label>Confirm Password:<sup>*</sup></label>

                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                    <span class="help-block"><?php echo $confirm_password_err; ?></span>

                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit">

                    <input type="reset" class="btn btn-default" value="Reset">

                </div>

                <p>Already have an account? <a href="login.php">Login here</a>.</p>

            </form>

        </div>    

    </body>

    </html>

