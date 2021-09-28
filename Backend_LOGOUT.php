<?php
session_start();
session_destroy();
header("location:Window_LOGIN.php");
exit;

?>