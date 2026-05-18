<?php
session_start();
unset($_SESSION['user_id'], $_SESSION['role']);
header('location: ../index.php');
die;