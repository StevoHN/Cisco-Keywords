<?php

if(!$_SESSION['admin_permissions'])
{
    header('location:login_.php');
}

?>