<?php
session_start();
//session_unset();
session_destroy();
$_SESSION = array();
//delete cookie ha!
//header('Location: /KnowITV1.1/login.php');

#header('Location: index.php');
header('Location: ./');
