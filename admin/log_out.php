<?php
session_start();
unset($_SESSION['admin_login']);
unset($_SESSION['admin_info']);
header('Location:index.php');