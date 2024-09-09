<?php
//admin panel: list databse entries
//allow admin to update fields, delete users, and add new users.

//user is an admin - show admin panel
//checking to see if same session available, otherwise do not allow anyone access to this page
session_start();


if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    $connection = mysqli_connect('localhost', 'HNCWEBMR7', 'db9Xq7Wtqm', 'HNCWEBMR7')
        or die('cannot connect');

    //sending query to SQL to select all users/members
    $database = "SELECT * FROM adminPanel";
    $dbResult = mysqli_query($connection, $database);

    //display dynamic DB content using loop:
    while ($row = mysqli_fetch_array($dbResult, MYSQLI_ASSOC)) {
        echo "<form method='POST'>";
        echo "<tr>";
        echo "<td><input type='text' name='username' value='" . $row['userName'] . "'</td>";
        echo "<td><input type='text' name='password' value='" . $row["userPassword"] . "'</td>";
        echo "<td><input type='hidden' name='hidden' value='" . $row["adminID"] . "'</td>";
        echo "<td><input type='submit' name='update' value='update'</td>";
        echo "<td><input type='submit' name='delete' value='delete'</td>";
        echo "</tr>";
        echo "</form>";
    }

    if (isset($_POST['update'])) {
        //creating query
        $updateQuery = "UPDATE adminPanel SET userName='$_POST[username]', userPassword='$_POST[password]' WHERE adminID='$_POST[hidden]'";
        //sending query to db
        $update = mysqli_query($connection, $updateQuery);
        //showing results
        if($update)
        {
            header("Location:admin.php");
        }else{
            echo "error";
        }
    }

    if (isset($_POST['delete'])) {
        //creating query
        $deleteQuery = "DELETE FROM adminPanel WHERE adminID='$_POST[hidden]'";
        //sending query to db
        $delete = mysqli_query($connection, $deleteQuery);
        //showing results
        if($delete)
        {
            header("Location:admin.php");
        }else{
            echo "error";
        }
    }

    mysqli_close($connection);

} else {
    header("Location:login.php");
    exit();
}



//if(isset($_POST["delete"])) {
//$deleteQuery = "DELETE FROM adminPanel WHERE adminID='$_POST[hidden]'";
//$delete = mysqli_query($connection, $deleteQuery);
//$deleteResult = "SELECT * FROM adminPanel";
//echo $deleteResult;
// }



?>