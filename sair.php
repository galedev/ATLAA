<?php
session_start();
unset($_SESSION["nickname"]);
unset($_SESSION["id_access"]);
session_destroy();
header("Location: index.php");
?>