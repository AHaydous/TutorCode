<?php

$databaseHost = 'localhost';
$databaseName = 'webproject';
$databaseUsername = 'root';
$databasePassword = '';
$databasePort = 3307;

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName, $databasePort);
if (!$conn) {
    die('Could not Connect My Sql:' . mysql_error());
}
?>
