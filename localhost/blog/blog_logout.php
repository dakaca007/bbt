<?php
require_once 'init.php';

session_unset();
session_destroy();
header("Location: blog_index.php");
exit();
?>
