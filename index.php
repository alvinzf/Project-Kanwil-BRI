<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Masukkan Username Anda";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Masukkan Password Anda";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($mysqli, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: home.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "Password tidak valid, silahkan coba lagi";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Akun tidak ditemukan";
                }
            } else {
                echo "Kesalahan terjadi, silahkan coba lagi";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="style2.css">

</head>
<style type="text/css">
    #inputbtn:hover {
        cursor: pointer;
    }

    .card {
        background: #f8f9fa;
        border-top-left-radius: 5% 5%;
        border-bottom-left-radius: 5% 5%;
        border-top-right-radius: 5% 5%;
        border-bottom-right-radius: 5% 5%;
    }
</style>

<body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff); background-size: cover;">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">

            <a class="navbar-brand js-scroll-trigger" href="index.php" style="margin-top: 10px;margin-left:-65px;font-family: 'IBM Plex Sans', sans-serif;">
                <h4>Website</h4>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            </div>
        </div>
    </nav>



    <div class="container-fluid" style="margin-top:60px;margin-bottom:60px;color:#34495E;">
        <div class="row">



            <div class="col-md-7" style="padding-left: 180px; ">
                <div class="col-md-3" style="margin-top: 19%;left: 8%">
                    <img src="https://www.multidana.id/wp-content/uploads/2017/01/logo-bri.png" alt=" " height="200" />
                </div>

            </div>

            <div class="col-md-4" style="margin-top: 5%;right: 8%">
                <div class="card" style="font-family: 'IBM Plex Sans', sans-serif;">
                    <div class="card-body">
                        <center>
                            <h3 style="margin-top: 10%">Login Admin</h3><br>
                            <form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row" style="margin-top: 10%">

                                    <div class="col-md-4"><label>Username: </label></div>
                                    <div class="col-md-8" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>><input type="text" name="username" class="form-control" placeholder="Username" required /></div><br><br>
                                    <span class="help-block"><?php echo $username_err; ?></span>


                                    <div class="col-md-4" style="margin-top: 8%"><label>Password: </label></div>
                                    <div class="col-md-8" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?> style="margin-top: 8%"><input type="password" class="form-control" name="password" placeholder="Masukkan Password" required /></div><br><br><br>
                                    <span class="help-block"><?php echo $password_err; ?></span>

                                </div>
                                <div class="row">
                                    <div class="col-md-4" style="padding-left: 450px;margin-top: 10%">
                                        <center><input type="submit" id="inputbtn" name="adsub" value="Login" class="btn btn-primary"></center>
                                    </div>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

</html>