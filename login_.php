<?php
session_start();
include 'include/db_cred.php';

if($_SESSION['admin_permissions'] == true)
{
    header('location:index.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if($_POST['c_username'] == $db_cred[c_username] && $_POST['c_password'] == $db_cred[c_password])
    {
        $_SESSION['admin_permissions'] = true;
        header('location:edit_.php');
    }
    else
    {
        $errMsg = 'Login Failed<br>Wrong username or password.';
        $_SESSION['admin_permissions'] = false;
    };
}

?>
<!DOCTYPE html>
<html>

    <head>
        <title>Cisco Keywords</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" href="style/style.css">
    </head>

    <body>
        <?php include 'buttons/navbar.php' ?>
		<div id="wrapper">
        <div style="margin-top: 100px">
            <div id="login_form">
                <form method="post" action="<?php echo $_SERVER[PHP_SELF]?>">
                    <label for="c_username">Username:</label>
                    <input type="text" name="c_username" id="c_username"/>
                    <label for="c_password">Password:</label>
                    <input type="password" name="c_password" id="c_password"/>
                    <br>
                    <input type="submit" value="Login"/>
                </form>
            <?php echo "<p style='margin-top:50px;'>" . $errMsg . "</p>"; ?>
            </div>
        </div>
		</div>
    </body>

</html>