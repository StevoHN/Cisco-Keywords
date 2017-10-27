<?php
session_start();

if($_SESSION['admin_permissions'] == true)
{
    $_SESSION['admin_permissions'] = false;
}

header('location:index.php');

?>