<?php
$host = "localhost";
$user = "root";
$pass = "mysql";
$database = "tp1-p1-lab-grupo";

$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
    die("error de conexión: " . $conn->connect_error);
}
