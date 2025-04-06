<?php
session_start();
include("../includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    echo '0';
    exit;
}

$user_id = $_SESSION['user_id'];
$count = $con->count('cart', ['user_id' => $user_id]);
echo $count;