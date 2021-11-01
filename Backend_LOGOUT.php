<?php
session_start();
session_destroy();
session_regenerate_id();
header("location:Window_LOGIN.php");
exit;

?>