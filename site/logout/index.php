<?php
session_start();
require '../inc/config.php';
$_SESSION = array();
if (isset($_COOKIE[session_name()]))
{
   $cookie_expires  = time() - date('Z') - 3600;
   setcookie(session_name(), '', $cookie_expires, '/');
}
unset($_SESSION);
header("Location: " . DIR );
exit();
?>