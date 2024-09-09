<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><input type="text" name="username" required>
        <label for="password">Password:</label><input type="password" name="password" required>
        <label for="submit"></label><input type="submit" name="submit">
    </form>
</body>


<?php

//script to log user in, tell if they are admin or not
//Check to see if log in credentials match database, if yes - redirect to home page "you are not admin"
//if user is admin - redirect to admin panel

//checking to see if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //making connection to database
    $connection = mysqli_connect('localhost', 'HNCWEBMR7', 'db9Xq7Wtqm', 'HNCWEBMR7')
        or die('cannot connect');

    //starting session
    session_start();

    //getting user input from log in form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //logging in user
    $userCheck = "SELECT * FROM adminPanel WHERE userName = '$username' AND userPassword = '$password'";
    $loginCheck = mysqli_query($connection,$userCheck);

    //checking if user logging in is admin. Admin ID needs to return true(YES)
    $adminCheck = "SELECT * FROM adminPanel WHERE userName = '$username' AND userPassword = '$password' AND adminID = '1'";
    $result = mysqli_query($connection, $adminCheck);

    //counting number of rows of the above database values
    $count = mysqli_num_rows($loginCheck);
    $countAdmin = mysqli_num_rows($result);

    if ($count == 1 && $countAdmin == 0) {
        //setting a session variable to hold the username. This can be checked on other pages
        $_SESSION["login"] = "$username";
        header("Location:home.php");
        //else if is checking if the user logging in is an admin
    }else if($count == 1 && $countAdmin == 1) {
        $_SESSION["login"] = "$username";
        header("Location:admin.php");
    }
    else {
        //error message if log in does not find any matches to database
        echo "Log in was unsuccessful. Please try again.";
    }

}

?>

</html>