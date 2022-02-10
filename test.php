<?php
//echo phpinfo();
session_start();
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;

echo $count . "<br/>";

$_SESSION['count'] = ++$count;
echo "server <br/>";
print_r($_SERVER);
?>
