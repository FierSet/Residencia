<?php
header("Access-Control-Allow-Headers: *");

$host = "localhost";
$user = "root";  //Miguel
$pass = "";     //MAOZcetzortega-1
$db = "recidencias";

$conexion = mysqli_connect( $host, $user, $pass, $db );
?>